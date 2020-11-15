<!DOCTYPE html>
<html lang="en">
<?php 
    try{
        if(!isset($_GET['countryId']))
            throw new Exception('country id not found!');
        $countryId=$_GET['countryId'];
    }
    catch(Exception $e){
        print($e->getMessage());
    }
?>
<?php include('../components/head.php'); ?>
<?php include("../components/navigation.php"); ?>
<?php include('../components/country_stats.php');?>
</html>