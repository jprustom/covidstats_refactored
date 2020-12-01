<?php include('../bootstrap.php');?>
<?php Configs::generateHead('Error!','../views/shared/images/icon.png',[
        "../views/shared/main.css",
        "../views/shared/navbar.css",
    ],[
        "homeLink"=>"../views/index/index.php",
        "addStatsLink"=>"../views/add/add.php",
        "addCountryLink"=>"../views/add_country/add_country.php"
    ]) ?>
<?php
    try{
        //Additional server side verification
        if (!isset($_POST['submit'])) throw new Exception('No request received!');
        if (!isset($_POST['countryName'])) throw new Exception('No country name provided');
        if (!isset($_FILES['countryFlag'])) throw new Exception('No country flag provided');

        //Extracting form data
        $countryName=$_POST['countryName']; //For eg france
        $countryFlagFileType=$_FILES['countryFlag']['type']; //should have substring image starting from index 0
        if (strpos($countryFlagFileType,'image')===false) //strict comparison is required
            throw new Exception('Please provide an image.');
        $countryFlagName=uniqid().'_'.$_FILES['countryFlag']['name']; //For eg 5fb0387973385_france.png

        //1-Check if country exists
        if (Countries::getCountryId($countryName)){
            $countryName=ucwords($countryName);
            throw new Exception("$countryName already exists in our solution.");
        }

        //2-Add new country
        (Countries::insertIntoCountries($countryName,$countryFlagName));
        $countryFlagTempName=$_FILES['countryFlag']['tmp_name'];
        move_uploaded_file($countryFlagTempName,'../views/shared/images/countriesFlags/'.$countryFlagName);
        
        //Country inserted Successfully! Redirect.
        header('Location: ../views/index/index.php');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>