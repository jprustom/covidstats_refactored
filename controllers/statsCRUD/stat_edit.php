<?php date_default_timezone_set ('Asia/Beirut'); ?>
<?php require_once('../../bootstrap.php');?>
<?php if (!$user)
    return header('Location:../../auth/signIn.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "signOutLink"=>"signout.php",
        "editProfileLink"=>"../../views/auth/editProfile.php",
        "pending"=>"../../views/pending/pending.php",
        'memberSignUpLink'=>"../../views/auth/signUp.php"
    ]) ?>
<?php
    try{
        if(!isset($_POST['countryId'])) throw new Exception('countryId was not set.');
        if(!isset($_POST['newCases'])) throw new Exception('new cases were not set.');
        if(!isset($_POST['newDeaths'])) throw new Exception('new deaths were not set.');
        if(!isset($_POST['statId'])) throw new Exception('stat id was not set.');
        $statId=(int)($_POST['statId']);
        if ($statId==0)
            throw new Exception('invalid stat id');
        $countryId=$_POST['countryId'];
        $new_cases=(int)($_POST['newCases']);
        $new_deaths=(int)($_POST['newDeaths']);
        
        if ($user->isAdmin)
            \Models\CovidStats::updateStat($statId,$new_cases,$new_deaths);
        else \Models\CovidStats::insertPendingStat($user->id,$new_cases,$new_deaths,$statId);

        header("Location:../../views/statsCRUD/statsCRUD.php?countryId=$countryId");
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>