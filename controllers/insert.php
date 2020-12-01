<?php 
    date_default_timezone_set ('Asia/Beirut'); 
    require_once('../views/head.php'); 
    require_once('../views/navigation.php');
?>
<?php
    try{
        if(!isset($_POST['date'])) throw new Exception('date was not set.');
        if(!isset($_POST['country'])) throw new Exception('country was not set.'); //should never execute since options have defaults
        if(!isset($_POST['newCases'])) throw new Exception('new cases were not set.');
        if(!isset($_POST['newDeaths'])) throw new Exception('new deaths were not set.');

        $country=$_POST['country'];
        $date=$_POST['date'];
        if (!preg_match("/^(0[1-9]|[12][0-9]|3[01])[- -.](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[- -.](19|20)\d\d$/",$date))
            throw new Exception("Please enter a valid date in the format dd-mm-YYYY");

        $today_date=(date("d-M-Y"));
        if ($date>$today_date)
            throw new Exception("Cannot insert future date $date!");
        //When parsing the data from body it will all be of type string
        //In my database class I will check with my PDO the int types
        $new_cases=(int)($_POST['newCases']);
        $new_deaths=(int)($_POST['newDeaths']);
        (MySQLDatabase::getMySqlDbh())->insertNewCoronaStats($country,$date,$new_cases,$new_deaths);

        header('Location: ../add.php');
    }
    catch(Exception $e){
        displayErrorMessage($e);
    }

?>