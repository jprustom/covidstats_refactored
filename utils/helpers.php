<?php
    function render_last_covidstats(){
        global $mysql_instance;
        $covidstats_rows=$mysql_instance->fetchLastStats();
        if (count($covidstats_rows)==0){
            print("<h1>No Countries Saved In Current Solution</h1>");
            return;
        }
        foreach($covidstats_rows as $row){
            render_last_covidstats_entry($row->countryId,$row->countryFlagFileName,$row->countryName,$row->lastCases,$row->lastDeaths);
        }
        }
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
    function renderCountriesSelect(){
        print ("<select required name='country'>".getCountriesOptions()."</select>");
    }
    function getCountriesOptions(){
        global $mysql_instance;
        $optionsContainer='';
        try{
            $countryObjArray=$mysql_instance->fetchAllCountries();
        }
        catch(Exception $e){
            displayErrorMessage($e);
        }
        foreach($countryObjArray as $countryObj){
            $countryName=ucwords($countryObj->countryName) ;
            $optionsContainer.="
                <option value='$countryName'>
                    $countryName 
                </option>
            ";
        }
        return $optionsContainer;
    }
    function displayErrorMessage(Exception $e){
        $messageToDisplay=$e->getMessage();
        print_r("<h1>$messageToDisplay</h1>");
        die();
    }
?>