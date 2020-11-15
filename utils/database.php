<?php
    class MySQLDatabase{
        function __construct(string $host,string $dbname,string $username,string $password,array $options=[]){
            $dsn="mysql:host=$host;dbname=$dbname";
            $this->dbh=new PDO($dsn,$username,$password,$options);
        }
        //The method below find the latest stats for each country to be displayed on home page index.php
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
        //getCountryId will help me with adding a new stat 
        //it will also help me while inserting a new country, making sure that it does not exist
        function getCountryId(string $countryName,bool $shouldCountryExist=false){
            $sqlStatementSelectCountry="SELECT id FROM countries WHERE countryName=:countryName";
            $pdoStatementSelectCountry=$this->dbh->prepare($sqlStatementSelectCountry);
            $pdoStatementSelectCountry->bindValue('countryName',$countryName,PDO::PARAM_STR);
            if($pdoStatementSelectCountry->execute()){
                $country_returned=$pdoStatementSelectCountry->fetch(PDO::FETCH_OBJ);
                if (!$country_returned){
                    if ($shouldCountryExist){
                        throw new Exception("$countryName was not found in our solution");
                        // die();
                    }
                    return false; //country does not exist->it can be inserted
                }
                return $country_returned->id;
            }
        }
        //Insert A New Country Record
        function insertIntoCountries(string $countryName,string $countryFlagFileName){
            $sqlStatementInsertIntoCountries='INSERT INTO countries (countryName,countryFlagFilename)
                                               VALUES (:countryName,:countryFlagFileName)';
            $pdoStatementInsertIntoCountries=$this->dbh->prepare($sqlStatementInsertIntoCountries);
            $pdoStatementInsertIntoCountries->bindValue('countryName',$countryName,PDO::PARAM_STR);
            $pdoStatementInsertIntoCountries->bindValue('countryFlagFileName',$countryFlagFileName,PDO::PARAM_STR);
            return $pdoStatementInsertIntoCountries->execute(); //returns false if execution fails, error is also printed
        }
        //Inserting new stats for a specific country
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
        //The function below will help me in rendering the add stats form
        function fetchAllCountries(){
            $sqlStatementSelectAll="SELECT countryName FROM countries";
            $pdoStatementSelectAll=$this->dbh->prepare($sqlStatementSelectAll); 
            $pdoStatementSelectAll->execute();
            $result=$pdoStatementSelectAll->fetchAll(PDO::FETCH_OBJ);
            return $result;
        }
        //fetchCountryStats to display details of each country stats
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
    }

?>