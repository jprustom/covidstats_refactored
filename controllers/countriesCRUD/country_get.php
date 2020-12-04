<?php
    try{
        if (!isset($_GET['countryId']))
            throw new Exception('missing countryId in arguments');
        $countryId=(int)$_GET['countryId'];
        if ($countryId==0)
            throw new Exception('invalid country Id');
        $country=\Models\Countries::getCountry($countryId);
        $countryName=$country->countryName;
        $countryFlagFileName=$country->countryFlagFilename;
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>