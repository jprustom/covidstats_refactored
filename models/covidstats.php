<?php
    //PLEASE NOTE THAT I SET MY RELATED TABLES TO CASCADE ON DELETE & UPDATE
    class CovidStats{
        //The method below find the latest stats for each country to be displayed on home page index.php
        public static function fetchLastStats(){
            $dbh=MySQLDatabase::getMySqlDbh();
            $sqlStatementGetLastStats="
                SELECT lastcovidstats.countryId,lastcovidstats.date,countries.countryFlagFileName,countries.countryName,lastcovidstats.lastCases,lastcovidstats.lastDeaths 
                FROM countries INNER JOIN
                (
                    SELECT allcovidstats.countryId,allcovidstats.date,allcovidstats.lastCases,allcovidstats.lastDeaths 
                    FROM covidstats AS allcovidstats
                    INNER JOIN 
                    (SELECT countryId,MAX(date) AS lastDate FROM covidstats GROUP BY countryId) lastcovidstats 
                    ON allcovidstats.countryId=lastcovidstats.countryId AND allcovidstats.date=lastcovidstats.lastDate
                    ) AS lastcovidstats
                    ON lastcovidstats.countryId=countries.id
                ";
            $pdoStatementLastStats=$dbh->prepare($sqlStatementGetLastStats);
            if ($pdoStatementLastStats->execute()){
                $result=$pdoStatementLastStats->fetchAll(PDO::FETCH_OBJ);
                return $result;
        }
            throw new Exception('Error while fetching last stats');
        }

        private static function deletePreviousStats(int $countryId,string $date){
            $dbh=MySQLDatabase::getMySqlDbh();
            $countryId=(int)($countryId);
            if ($countryId==0)
                throw new Exception('invalid Id');
            $sqlStatementDeletePreviousStats="DELETE FROM covidstats 
                WHERE countryId=:countryId
                AND date=STR_TO_DATE(:dateOfStat,:dateFormat)";
            $pdoStatementDeletePreviousStats=$dbh->prepare($sqlStatementDeletePreviousStats);
            $pdoStatementDeletePreviousStats->bindValue('countryId',$countryId,PDO::PARAM_INT);
            $pdoStatementDeletePreviousStats->bindValue('dateOfStat',$date,PDO::PARAM_STR);
            $pdoStatementDeletePreviousStats->bindValue('dateFormat','%d-%b-%Y',PDO::PARAM_STR);
            if (!$pdoStatementDeletePreviousStats->execute())
                throw new Exception('An error occured while trying to check if stat already exists.');
        }
        //Inserting new stats for a specific country
        public static function insertNewCoronaStats(string $countryName,string $date,int $newCases,int $newDeaths){
            $dbh=MySQLDatabase::getMySqlDbh();
            $countryId=Countries::getCountryId($countryName,true); //throw exception if false
            //I could have checked if record with same date exists, and if so update, otherwise insert new row
            self::deletePreviousStats($countryId,$date); //overwrite previous stats for same date
            $sqlStatementInsertStats="INSERT INTO covidstats (countryId,date,lastCases,lastDeaths)
                                                VALUES (:countryId,STR_TO_DATE(:date,:dateFormat),:lastCases,:lastDeaths)";
            $pdoStatementInsertIntoCountries=$dbh->prepare($sqlStatementInsertStats);
            $pdoStatementInsertIntoCountries->bindValue('countryId',$countryId,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('date',$date,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('dateFormat','%d-%b-%Y',PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('lastCases',$newCases,PDO::PARAM_INT);
            $pdoStatementInsertIntoCountries->bindValue('lastDeaths',$newDeaths,PDO::PARAM_INT);
            if(!$pdoStatementInsertIntoCountries->execute())
                throw new Exception('Something went wrong while inserting new corona stats');
        }

        //fetchCountryStats to display details of each country stats
        public static function fetchCountryStats(int $countryId){
            $dbh=MySQLDatabase::getMySqlDbh();
            $countryId=(int)($countryId);
            if ($countryId==0)
                throw new Exception('invalid country Id');
            $sqlStatementAllCountryStats="SELECT countryName,countryFlagFileName,date,lastCases,lastDeaths  
                FROM covidstats  INNER JOIN countries
                ON countries.id=covidstats.countryId   
                WHERE countryId=:countryId   
                ORDER BY date DESC";
            $pdoStatementAllCountryStats=$dbh->prepare( $sqlStatementAllCountryStats); 
            $pdoStatementAllCountryStats->bindValue('countryId',$countryId,PDO::PARAM_INT);
            if($pdoStatementAllCountryStats->execute()){
                $result=$pdoStatementAllCountryStats->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
            throw new Exception("Error while fetching country stats");
        }
            }
            
?>