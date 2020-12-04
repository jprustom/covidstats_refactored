<?php require_once('../../bootstrap.php');?>
<?php if (!$_SESSION['user'])
        header('Location:../../views/admin/signIn.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/admin/signIn.php",
        "signOutLink"=>"../admin/signout.php",
        "changePassLink"=>"../../views/admin/changePass.php"
    ]) ?>
<?php
    try{
        if (!isset($_GET['statId']))
            throw new Exception('Stat to delete was not defined.');
        $statId=(int)($_GET['statId']);
        if ($statId===0)
            throw new Exception('Invalid statId');
        if (!isset($_GET['countryId']))
            throw new Exception('country id must be passed to redirect user to appropriate country after delete');
        $countryId=(int)($_GET['countryId']);
        if ($countryId==0)
            throw new Exception('invalid country id');
        \Models\CovidStats::deleteStat($statId);
        header("Location:../../views/statsCRUD/statsCRUD.php?countryId=$countryId");
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
?>