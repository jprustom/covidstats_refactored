<?php require_once('../../bootstrap.php');?>
<?php if (!$_SESSION['user'])
        header('Location:../../views/admin/signIn.php');?>
<?php Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_last_stats_view/countries_last_stats_view.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/admin/signIn.php",
        "signOutLink"=>"../admin/signout.php",
        "changePassLink"=>"../../views/admin/changePass.php"
    ]) ?>
<?php
    try{
        if (!isset($_GET['countryId']))
        throw new Exception('Country to delete was not defined.');
        if (!isset($_GET['countryFlagFileName']))
            throw new Exception('unset country flag file name');
        $countryId=(int)($_GET['countryId']);
        $countryFlagFileName=$_GET['countryFlagFileName'];
        if ($countryId===0)
            throw new Exception('Invalid countryId');
        Countries::deleteCountry($countryId);
        unlink('../../views/shared/images/countriesFlags/$countryFlagFileName');
        header('Location:../../views/countriesCRUD/countriesCRUD.php');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>