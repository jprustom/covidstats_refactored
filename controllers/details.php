<?php
    try{
        if(!isset($_GET['countryId']))
            throw new Exception('country id not found!');
        $countryId=$_GET['countryId'];
        $countryName=$_GET['countryName'];
        $countryFlagFileName=$_GET['countryFlagFileName'];
        $countryFlagImagePath="../shared/images/countriesFlags/$countryFlagFileName";
        $countryStats=CovidStats::fetchCountryStats((int)($countryId));
        
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }


?>