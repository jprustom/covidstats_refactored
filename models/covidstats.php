<?php namespace Models;
    //PLEASE NOTE THAT I SET MY RELATED TABLES TO CASCADE ON DELETE & UPDATE
    class CovidStats{
        public static function approveStat(int $pendingStatId){
            $pendingStat=self::getPendingStat($pendingStatId);
            self::updateStat($pendingStat->covidStatId,$pendingStat->lastCases,$pendingStat->lastDeaths,$pendingStat->userId);
            self::deletePendingStat($pendingStatId);
        }
        
        private static function getPendingStat($pendingStatId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh(); 
            $sqlStatementGetPendingStat="SELECT * FROM pendingcovidstats WHERE id=:id";
            $pdoStatementGetPendingStat=$dbh->prepare($sqlStatementGetPendingStat);
            $pdoStatementGetPendingStat->bindValue('id',$pendingStatId);
            if (!$pdoStatementGetPendingStat->execute())
                throw new \Exception('something went wrong while getting pending stat');
            if ($pdoStatementGetPendingStat->rowCount()==0)
                throw new \Exception('no pending stat was returned');
            return $pdoStatementGetPendingStat->fetch(\PDO::FETCH_OBJ);
        }
        public static function deletePendingStat(int $pendingStatId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh(); 
            $sqlStatementDeleteStat="DELETE FROM pendingcovidstats WHERE id=:id";
            $pdoStatementDeleteStat=$dbh->prepare($sqlStatementDeleteStat);
            $pdoStatementDeleteStat->bindValue('id',$pendingStatId,\PDO::PARAM_INT);
            if (!$pdoStatementDeleteStat->execute())
                throw new \Exception('something wrong happened while deleting stat');
            if ($pdoStatementDeleteStat->rowCount()==0)
                throw new \Exception('pending stat was not deleted');
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
        public static function insertPendingStat(int $userId,int $lastCases,int $lastDeaths,int $covidstatId=null,string $date=null,int $countryId=null){
            $dbh=\Library\MySQLDatabase::getMySqlDbh(); 
            $isMemberAddingNewStatRequest=$covidstatId==null && $date!=null && $countryId!=null;
            $sqlStatementInsertIntoPendingStats=
                $isMemberAddingNewStatRequest
                        ?"INSERT INTO pendingcovidstats (lastCases,lastDeaths,userId,date,countryId)
                            VALUES (:lastCases,:lastDeaths,:userId,STR_TO_DATE(:date,:dateFormat),:countryId)"
                        :"INSERT INTO pendingcovidstats (lastCases,lastDeaths,userId,covidStatId)
                            VALUES (:lastCases,:lastDeaths,:userId,:covidstatId)";
            $pdoStatementInsertIntoPendingStats=$dbh->prepare($sqlStatementInsertIntoPendingStats);
            $pdoStatementInsertIntoPendingStats->bindValue('lastCases',$lastCases,\PDO::PARAM_INT);
            $pdoStatementInsertIntoPendingStats->bindValue('lastDeaths',$lastDeaths,\PDO::PARAM_INT);
            $pdoStatementInsertIntoPendingStats->bindValue('userId',$userId,\PDO::PARAM_INT);
            if ($isMemberAddingNewStatRequest){
                $pdoStatementInsertIntoPendingStats->bindValue('countryId',$countryId,\PDO::PARAM_INT);
                $pdoStatementInsertIntoPendingStats->bindValue('date',$date,\PDO::PARAM_STR);
                $pdoStatementInsertIntoPendingStats->bindValue('dateFormat','%d-%b-%Y',\PDO::PARAM_STR);
            }
            else $pdoStatementInsertIntoPendingStats->bindValue('covidstatId',$covidstatId,\PDO::PARAM_INT);
            if (!$pdoStatementInsertIntoPendingStats->execute())
                throw new \Exception('something went wrong went inserting pending stat');
            if ($pdoStatementInsertIntoPendingStats->rowCount()==0)
                throw new \Exception('pending stat was not inserted');
        }
        public static function getPendingStatsToEdit(){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectPendingStats="SELECT pendingcovidstats.covidStatId,pendingcovidstats.id,countryName,pendingcovidstats.date as pendingCovidStatDate,covidstats.date as covidstatDate,pendingcovidstats.lastCases,pendingcovidstats.lastDeaths,pendingcovidstats.userId  
                FROM `pendingcovidstats` INNER JOIN `covidstats` on pendingcovidstats.covidStatId=covidstats.id 
                INNER JOIN countries ON covidstats.countryId=countries.id";
            $pdoStatementSelectPendingStats=$dbh->prepare($sqlStatementSelectPendingStats);
            if (!$pdoStatementSelectPendingStats->execute())
                throw new \Exception('something went wrong when fetching pending stats');
            return $pdoStatementSelectPendingStats->fetchAll(\PDO::FETCH_OBJ);
        }
        public static function getPendingStatsToAdd(){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectPendingStats="SELECT * from pendingcovidstats WHERE covidStatId IS NULL";
            $pdoStatementSelectPendingStats=$dbh->prepare($sqlStatementSelectPendingStats);
            if (!$pdoStatementSelectPendingStats->execute())
                throw new \Exception('something went wrong when fetching pending stats to be added');
            return $pdoStatementSelectPendingStats->fetchAll(\PDO::FETCH_OBJ);
        }
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

        public static function updateStat(int $statId,int $lastCases,int $lastDeaths,int $userId=0){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdateStat=
                $userId==0
                    ?"UPDATE covidstats SET lastCases=:lastCases,lastDeaths=:lastDeaths
                        WHERE id=:statId"
                    :"UPDATE covidstats SET lastCases=:lastCases,lastDeaths=:lastDeaths,userId=:userId
                        WHERE id=:statId";                   
            $pdoStatementUpdateStat=$dbh->prepare($sqlStatementUpdateStat);
            $pdoStatementUpdateStat->bindValue('statId',$statId,\PDO::PARAM_INT);
            $pdoStatementUpdateStat->bindValue('lastCases',$lastCases,\PDO::PARAM_INT);
            $pdoStatementUpdateStat->bindValue('lastDeaths',$lastDeaths,\PDO::PARAM_INT);
            if ($userId!=0)
                $pdoStatementUpdateStat->bindValue('userId',$userId,\PDO::PARAM_INT);
            if (!$pdoStatementUpdateStat->execute())
                throw new \Exception('something went wrong when updating stat');
            if ($pdoStatementUpdateStat->rowCount()==0)
                throw new \Exception('stat was not updated');
        }
        //fetchCountryStats to display details of each country stats
        public static function fetchCountryStats(int $countryId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $countryId=(int)($countryId);
            if ($countryId==0)
                throw new \Exception('invalid country Id');
            $sqlStatementAllCountryStats="SELECT covidstats.userId,covidstats.id,lastCases,lastDeaths,date,countryId,countries.countryName,countries.countryFlagFileName  
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