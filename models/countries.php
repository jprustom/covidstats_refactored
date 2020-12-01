<?php

    class Countries{
        
        //I prefer reaching out to dbh at each query, rather than defining it as a private variable here

        //getCountryId will help me with adding a new stat 
        //it will also help me while inserting a new country, making sure that it does not exist
        public static function getCountryId(string $countryName,bool $shouldCountryExist=false){
            $dbh=MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectCountry="SELECT id FROM countries WHERE countryName=:countryName";
            $pdoStatementSelectCountry=$dbh->prepare($sqlStatementSelectCountry);
            $pdoStatementSelectCountry->bindValue('countryName',$countryName,PDO::PARAM_STR);
            if($pdoStatementSelectCountry->execute()){
                $country_returned=$pdoStatementSelectCountry->fetch(PDO::FETCH_OBJ);
                if (!$country_returned){
                    if ($shouldCountryExist){
                        throw new Exception("$countryName was not found in our solution");
                    }
                    return false; //country does not exist->it can be inserted
                }
                return (int)($country_returned->id);
            }
            throw new Exception('An error occured while trying to fetch country Id');
        }
        //The function below will help me in rendering the add stats form
        public static function fetchAllCountries(){
            $dbh=MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectAll="SELECT countryName FROM countries";
            $pdoStatementSelectAll=$dbh->prepare($sqlStatementSelectAll); 
            if ($pdoStatementSelectAll->execute()){
                $result=$pdoStatementSelectAll->fetchAll(PDO::FETCH_OBJ);
                return $result;
            }
            throw new Exception('error while fetching countries');

        }
        //Insert A New Country Record
        public static function insertIntoCountries(string $countryName,string $countryFlagFileName){
            $dbh=MySQLDatabase::getMySqlDbh();
            $sqlStatementInsertIntoCountries='INSERT INTO countries (countryName,countryFlagFilename)
                                            VALUES (:countryName,:countryFlagFileName)';
            $pdoStatementInsertIntoCountries=$dbh->prepare($sqlStatementInsertIntoCountries);
            $pdoStatementInsertIntoCountries->bindValue('countryName',$countryName,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('countryFlagFileName',$countryFlagFileName,PDO::PARAM_STR);
            if(!$pdoStatementInsertIntoCountries->execute()){; //returns false if execution fails, error is also printed
                throw new Exception('Something went wrong when adding new country');
            }
        }
    }

?>