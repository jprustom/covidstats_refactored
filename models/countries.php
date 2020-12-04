<?php namespace Models;

    //PLEASE NOTE THAT I SET MY RELATED TABLES TO CASCADE ON DELETE & UPDATE
    class Countries{
        
        //I prefer reaching out to dbh at each query, rather than defining it as a private variable here
        //I don't want a private variable storing dbh, because I would have to instantiate this class, which I find not necessay
        //I also can't set a static private dbh here, since static variables should be known at compile time (should be const)

        //getCountryId will help me with adding a new stat 
        //it will also help me while inserting a new country, making sure that it does not exist
        public static function getCountryId(string $countryName,bool $shouldCountryExist=false){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectCountry="SELECT id FROM countries WHERE countryName=:countryName";
            $pdoStatementSelectCountry=$dbh->prepare($sqlStatementSelectCountry);
            $pdoStatementSelectCountry->bindValue('countryName',$countryName,\PDO::PARAM_STR);
            if($pdoStatementSelectCountry->execute()){
                $country_returned=$pdoStatementSelectCountry->fetch(\PDO::FETCH_OBJ);
                if (!$country_returned){
                    if ($shouldCountryExist){
                        throw new \Exception("$countryName was not found in our solution");
                    }
                    return false; //country does not exist->it can be inserted
                }
                return (int)($country_returned->id);
            }
            throw new \Exception('An error occured while trying to fetch country Id');
        }
        public static function deleteCountry(int $countryId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementDeleteCountry="DELETE FROM countries WHERE id=:countryId";
            $pdoStatementDeleteCountry=$dbh->prepare($sqlStatementDeleteCountry);
            $pdoStatementDeleteCountry->bindValue('countryId',$countryId);
            if (!$pdoStatementDeleteCountry->execute())
                throw new \Exception('something went wrong when deleting country');
            
        }
        //The function below will help me in rendering the add stats form
        public static function fetchAllCountries(){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectAll="SELECT * FROM countries";
            $pdoStatementSelectAll=$dbh->prepare($sqlStatementSelectAll); 
            if ($pdoStatementSelectAll->execute()){
                $result=$pdoStatementSelectAll->fetchAll(\PDO::FETCH_OBJ);
                return $result;
            }
            throw new \Exception('error while fetching countries');

        }
        //Insert A New Country Record
        public static function insertIntoCountries(string $countryName,string $countryFlagFileName){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementInsertIntoCountries='INSERT INTO countries (countryName,countryFlagFilename)
                                            VALUES (:countryName,:countryFlagFileName)';
            $pdoStatementInsertIntoCountries=$dbh->prepare($sqlStatementInsertIntoCountries);
            $pdoStatementInsertIntoCountries->bindValue('countryName',$countryName,\PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('countryFlagFileName',$countryFlagFileName,\PDO::PARAM_STR);
            if(!$pdoStatementInsertIntoCountries->execute()){; //returns false if execution fails, error is also printed
                throw new \Exception('Something went wrong when adding new country');
            }
        }

        public static function getCountry(int $countryId){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectCountry="SELECT * FROM countries WHERE id=:countryId";
            $pdoStatementSelectCountry=$dbh->prepare($sqlStatementSelectCountry);
            $pdoStatementSelectCountry->bindValue('countryId',$countryId,\PDO::PARAM_INT);
            if($pdoStatementSelectCountry->execute()){
                $country_returned=$pdoStatementSelectCountry->fetch(\PDO::FETCH_OBJ);
                return $country_returned;
            }
            throw new \Exception('An error occured while trying to fetch country Id');
        }
        public static function updateCountry(int $countryId,string $countryName,string $countryFlagFileName){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdateCountry="UPDATE countries SET countryName=:countryName, countryFlagFilename=:countryFlagFileName
                                        WHERE id=:countryId";
            $pdoStatementUpdateCountry=$dbh->prepare($sqlStatementUpdateCountry);
            $pdoStatementUpdateCountry->bindValue('countryName',$countryName);
            $pdoStatementUpdateCountry->bindValue('countryFlagFileName',$countryFlagFileName);
            $pdoStatementUpdateCountry->bindValue('countryId',$countryId);
            if (!$pdoStatementUpdateCountry->execute())
                throw new \Exception('something went wrong when updating country');
        }
    }
    

?>