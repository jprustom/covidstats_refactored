<?php 
    require_once('../components/head.php'); 
    require_once('../components/navigation.php');  
?>
<?php
    try{
        //Additional server side verification
        if (!isset($_POST['submit'])) throw new Exception('No request received!');
        if (!isset($_POST['countryName'])) throw new Exception('No country name provided');
        if (!isset($_FILES['countryFlag'])) throw new Exception('No country flag provided');

        //Extracting form data
        $countryName=$_POST['countryName']; //For eg france
        $countryFlagName=uniqid().'_'.$_FILES['countryFlag']['name']; //For eg 5fb0387973385_france.png

        //1-Check if country exists
        if ($mysql_instance->getCountryId($countryName)){
            $countryName=ucwords($countryName);
            throw new Exception("$countryName already exists in our solution.");
        }

        //2-Add new country
        $mysql_instance->insertIntoCountries($countryName,$countryFlagName);
        $countryFlagTempName=$_FILES['countryFlag']['tmp_name'];
        move_uploaded_file($countryFlagTempName,'../images/countriesFlags/'.$countryFlagName);
        
        //Country inserted Successfully! Redirect.
        header('Location: ../index.php');
    }
    catch(Exception $e){
        displayErrorMessage($e);
    }
?>