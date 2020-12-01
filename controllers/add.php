<?php
    try{
        $countryObjArray=Countries::fetchAllCountries();
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>