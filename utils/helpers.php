<?php
    $mysql_instance=new MySQLDatabase(
        $coronastats_db_config['host'],
        $coronastats_db_config['database'],
        $coronastats_db_config['username'],
        $coronastats_db_config['password']);


    function render_last_covidstats_entry(string $countryId,string $countryFlagFileName,string $countryName, string $lastCases, string $lastDeaths){
        $detailsPath="./routes/details.php?countryId=$countryId&countryName=$countryName&countryFlagFileName=$countryFlagFileName";
        print("
            <div class='covidstats-table__entry'>
                <div class='covidstats-table__entry--country-flag'><a href='$detailsPath'><img alt='$countryName flag' src='./images/countriesFlags/$countryFlagFileName'/></a></div>
                <div class='covidstats-table__entry--country-name'><a href='$detailsPath'>$countryName</a></div>
                <div>$lastCases</div>
                <div>$lastDeaths</div>
            </div>
        ");
    }
    function render_last_covidstats(){
        global $mysql_instance;
        foreach($mysql_instance->fetchLastStats() as $row){
   
            render_last_covidstats_entry($row->countryId,$row->countryFlagFileName,$row->countryName,$row->lastCases,$row->lastDeaths);
        }
        }
    function getCountriesOptions(){
        global $mysql_instance;
        $optionsContainer='';
        $countryObjArray=$mysql_instance->fetchAllCountries();
        foreach($countryObjArray as $countryObj){
            $countryName=ucwords($countryObj->countryName) ;
            $optionsContainer.="
                <option value=$countryName>
                    $countryName 
                </option>
            ";
        }
        return $optionsContainer;
    }
    function renderCountriesSelect(){
        print ("<select name='country'>".getCountriesOptions()."</select>");
    }
    function displayErrorMessage(Exception $e){
        global $inside_utils;
        if ($inside_utils)
            include('../components/head.php'); 
        $messageToDisplay=$e->getMessage();
        print_r("<h1>$messageToDisplay</h1>");
        header( "refresh:3;url=../" );
    }
?>