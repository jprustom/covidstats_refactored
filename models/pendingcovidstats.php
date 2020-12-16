<?php namespace Models;
    class PendingCovidStats{
        public static function approveStatUpdate(int $pendingStatId){
            $pendingStat=self::getPendingStat($pendingStatId);
            CovidStats::updateStat($pendingStat->covidStatId,$pendingStat->lastCases,$pendingStat->lastDeaths,$pendingStat->userId);
            self::deletePendingStat($pendingStatId);
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
    }
?>