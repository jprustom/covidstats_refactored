<?php require_once('../../bootstrap.php');?>
<?php if (!isset($_SESSION['user']) || !$user->isAdmin)
        header('Location:../../index.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "signOutLink"=>"../auth/signout.php",
        "editProfileLink"=>"../../views/auth/editProfile.php",
        "pending"=>"../../views/pending/pending.php",
        "memberSignUpLink"=>"../../views/auth/signUp.php",
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