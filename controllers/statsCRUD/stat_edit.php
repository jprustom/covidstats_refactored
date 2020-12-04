<?php date_default_timezone_set ('Asia/Beirut'); ?>
<?php require_once('../../bootstrap.php');?>
<?php if (!$_SESSION['user'])
    header('Location:../../admin/signIn.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/admin/signIn.php",
        "signOutLink"=>"signout.php",
        "changePassLink"=>"../../views/admin/changePass.php"
    ]) ?>
<?php
    try{
        if(!isset($_POST['date'])) throw new Exception('date was not set.');
        if(!isset($_POST['countryId'])) throw new Exception('countryId was not set.');
        if(!isset($_POST['newCases'])) throw new Exception('new cases were not set.');
        if(!isset($_POST['newDeaths'])) throw new Exception('new deaths were not set.');
        if(!isset($_POST['statId'])) throw new Exception('stat id was not set.');
        $statId=(int)($_POST['statId']);
        if ($statId==0)
            throw new Exception('invalid stat id');
        $countryId=$_POST['countryId'];
        $date=$_POST['date'];
        if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])[- -.](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[- -.](19|20)\d\d$/",$date))
            throw new Exception("Please enter a valid date in the format dd-mm-YYYY");

        $today_date=(date("d-M-Y"));
        if (strtotime($date)>strtotime($today_date))
            throw new Exception("Cannot insert future date $date!");
        //When parsing the data from body it will all be of type string
        //In my database class I will check with my PDO the int types
        $new_cases=(int)($_POST['newCases']);
        $new_deaths=(int)($_POST['newDeaths']);
        \Models\CovidStats::updateStat($statId,[
            "countryId"=>$countryId,
            "date"=>$date,
            "lastCases"=>$new_cases,
            "lastDeaths"=>$new_deaths
        ]);

        header("Location: ../../views/statsCRUD/statsCRUD.php?countryId=$countryId");
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>