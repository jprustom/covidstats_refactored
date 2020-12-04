<?php require_once('../../controllers/countriesCRUD/countries_get.php');?>
<?php if (!$_SESSION['user'])
    header('Location:../admin/signIn.php');?>
<?php 
    if (!isset($_GET['countryId']))
        $_GET['countryId']=$countries[0]->id;
?>
<?php
    $countryId=$_GET['countryId'];
    $countryStats=\Models\CovidStats::fetchCountryStats((int)($countryId));

?>