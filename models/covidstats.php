<?php namespace Models;
    //PLEASE NOTE THAT I SET MY RELATED TABLES TO CASCADE ON DELETE & UPDATE
    class CovidStats{
        //The method below find the latest stats for each country to be displayed on home page index.php
        public static function fetchLastStats(){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
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
                $result=$pdoStatementLastStats->fetchAll(\PDO::FETCH_OBJ);
                return $result;
        }
            throw new \Exception('Error while fetching last stats');
        }

        private static function deletePreviousStats(int $countryId,string $date){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $countryId=(int)($countryId);
            if ($countryId==0)
                throw new \Exception('invalid Id');
            $sqlStatementDeletePreviousStats="DELETE FROM covidstats 
                WHERE countryId=:countryId
                AND date=STR_TO_DATE(:dateOfStat,:dateFormat)";
            $pdoStatementDeletePreviousStats=$dbh->prepare($sqlStatementDeletePreviousStats);
            $pdoStatementDeletePreviousStats->bindValue('countryId',$countryId,\PDO::PARAM_INT);
            $pdoStatementDeletePreviousStats->bindValue('dateOfStat',$date,\PDO::PARAM_STR);
            $pdoStatementDeletePreviousStats->bindValue('dateFormat','%d-%b-%Y',\PDO::PARAM_STR);
            if (!$pdoStatementDeletePreviousStats->execute())
                throw new \Exception('An error occured while trying to check if stat already exists.');
        }
        //Inserting new stats for a specific country
        public static function insertNewCoronaStats(int $countryId, string $date,int $newCases,int $newDeaths){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            //I could have checked if record with same date exists, and if so update, otherwise insert new row
            self::deletePreviousStats($countryId,$date); //overwrite previous stats for same date
            $sqlStatementInsertStats="INSERT INTO covidstats (countryId,date,lastCases,lastDeaths)
                                                VALUES (:countryId,STR_TO_DATE(:date,:dateFormat),:lastCases,:lastDeaths)";
            $pdoStatementInsertIntoCountries=$dbh->prepare($sqlStatementInsertStats);
            $pdoStatementInsertIntoCountries->bindValue('countryId',$countryId,\PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('date',$date,\PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('dateFormat','%d-%b-%Y',\PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('lastCases',$newCases,\PDO::PARAM_INT);
            $pdoStatementInsertIntoCountries->bindValue('lastDeaths',$newDeaths,\PDO::PARAM_INT);
            if(!$pdoStatementInsertIntoCountries->execute())
                throw new \Exception('Something went wrong while inserting new corona stats');
        }
        public static function updateStat(int $statId,array $statProps){
            $countryId=$statProps['countryId'];
            $date=$statProps['date'];
            $lastCases=$statProps['lastCases'];
            $lastDeaths=$statProps['lastDeaths'];
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdateCountry="UPDATE covidstats SET countryId=:countryId, date=STR_TO_DATE(:date,:dateFormat),lastCases=:lastCases,lastDeaths=:lastDeaths
                                        WHERE id=:statId";
            $pdoStatementUpdateCountry=$dbh->prepare($sqlStatementUpdateCountry);
            $pdoStatementUpdateCountry->bindValue('statId',$statId,\PDO::PARAM_INT);
            $pdoStatementUpdateCountry->bindValue('date',$date,\PDO::PARAM_STR);
            $pdoStatementUpdateCountry->bindValue('dateFormat','%d-%b-%Y',\PDO::PARAM_STR);
            $pdoStatementUpdateCountry->bindValue('countryId',$countryId,\PDO::PARAM_INT);
            $pdoStatementUpdateCountry->bindValue('lastCases',$lastCases,\PDO::PARAM_INT);
            $pdoStatementUpdateCountry->bindValue('lastDeaths',$lastDeaths,\PDO::PARAM_INT);
            if (!$pdoStatementUpdateCountry->execute())
                throw new \Exception('something went wrong when updating country');
        }
        //fetchCountryStats to display details of each country stats
        public static function fetchCountryStats(int $countryId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $countryId=(int)($countryId);
            if ($countryId==0)
                throw new \Exception('invalid country Id');
            $sqlStatementAllCountryStats="SELECT covidstats.id,lastCases,lastDeaths,date,countryId,countries.countryName,countries.countryFlagFileName  
                FROM covidstats  INNER JOIN countries
                ON countries.id=covidstats.countryId   
                WHERE countryId=:countryId   
                ORDER BY date DESC";
            $pdoStatementAllCountryStats=$dbh->prepare( $sqlStatementAllCountryStats); 
            $pdoStatementAllCountryStats->bindValue('countryId',$countryId,\PDO::PARAM_INT);
            if($pdoStatementAllCountryStats->execute()){
                $result=$pdoStatementAllCountryStats->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            }
            throw new \Exception("Error while fetching country stats");
        }
        public static function deleteStat(int $statId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementDeleteStat="DELETE FROM covidstats WHERE id=:statId";
            $pdoStatementDeleteStat=$dbh->prepare($sqlStatementDeleteStat);
            $pdoStatementDeleteStat->bindValue('statId',$statId);
            if (!$pdoStatementDeleteStat->execute())
                throw new \Exception('something went wrong when deleting stat');
        }
        public static function getStat(int $statId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementGetStat='SELECT * FROM covidstats WHERE id=:statId';
            $pdoStatementGetStat=$dbh->prepare($sqlStatementGetStat);
            $pdoStatementGetStat->bindValue('statId',$statId);
            if (!$pdoStatementGetStat->execute())
                throw new \Exception('something went wrong while getting stat');
            $result=$pdoStatementGetStat->fetch(\PDO::FETCH_OBJ);
            return $result;
        }
            }

            
?>