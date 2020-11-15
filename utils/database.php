<?php
    class MySQLDatabase{
        function __construct(string $host,string $dbname,string $username,string $password,array $options=[]){
            $dsn="mysql:host=$host;dbname=$dbname";
            $this->dbh=new PDO($dsn,$username,$password,$options);
        }
        function fetchAllCountries(){
            $sqlStatementSelectAll="SELECT countryName FROM countries";
            $pdoStatementSelectAll=$this->dbh->prepare($sqlStatementSelectAll); 
            $pdoStatementSelectAll->execute();
            $result=$pdoStatementSelectAll->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
        function fetchCountryStats($countryId){
            $sqlStatementAllCountryStats="SELECT countryName,countryFlagFileName,date,lastCases,lastDeaths  
                FROM covidstats  INNER JOIN countries
                ON countries.id=covidstats.countryId   
                WHERE countryId=:countryId   
                ORDER BY date DESC";
            $pdoStatementAllCountryStats=$this->dbh->prepare( $sqlStatementAllCountryStats); 
            $pdoStatementAllCountryStats->bindValue('countryId',$countryId,PDO::PARAM_INT);
            $pdoStatementAllCountryStats->execute();
            $result=$pdoStatementAllCountryStats->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
        function fetchLastStats(){
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
            $pdoStatementLastStats=$this->dbh->prepare($sqlStatementGetLastStats);
            $pdoStatementLastStats->execute();
            $result=$pdoStatementLastStats->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }

        function getCountryId(string $countryName,bool $checkIfExists=false){
            $sqlStatementSelectCountry="SELECT id FROM countries WHERE countryName=:countryName";
            $pdoStatementSelectCountry=$this->dbh->prepare($sqlStatementSelectCountry);
            $pdoStatementSelectCountry->bindValue('countryName',$countryName,PDO::PARAM_STR);
            if($pdoStatementSelectCountry->execute()){
                $country_returned=$pdoStatementSelectCountry->fetch(PDO::FETCH_OBJ);
                if (!$country_returned){
                    if ($checkIfExists){
                        throw new Exception("$countryName was not found in our solution");
                        // die();
                    }
                    return false;
                }
                return $country_returned->id;
            }
        }
        function insertIntoCountries(string $countryName,string $countryFlagFileName){
            $sqlStatementInsertIntoCountries='INSERT INTO countries (countryName,countryFlagFilename)
                                                          VALUES (:countryName,:countryFlagFileName)';
            $pdoStatementInsertIntoCountries=$this->dbh->prepare($sqlStatementInsertIntoCountries);
            $pdoStatementInsertIntoCountries->bindValue('countryName',$countryName,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('countryFlagFileName',$countryFlagFileName,PDO::PARAM_STR);
            return $pdoStatementInsertIntoCountries->execute();
        }
        
        function insertNewCoronaStats(string $countryName,string $date,string $newCases,string $newDeaths){
            $countryId=$this->getCountryId($countryName,true); //throw exception if false
            
            $sqlStatementInsertStats='INSERT INTO covidstats (countryId,date,lastCases,lastDeaths)
                                                VALUES (:countryId,:date,:lastCases,:lastDeaths)';
            $pdoStatementInsertIntoCountries=$this->dbh->prepare($sqlStatementInsertStats);
            $pdoStatementInsertIntoCountries->bindValue('countryId',$countryId,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('date',$date,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('lastCases',$newCases,PDO::PARAM_INT);
            $pdoStatementInsertIntoCountries->bindValue('lastDeaths',$newDeaths,PDO::PARAM_INT);
            return $pdoStatementInsertIntoCountries->execute();
        }
    }

?>