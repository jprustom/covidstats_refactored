<?php 
    include_once("./configs.php");  
    include_once("./database.php");  
    include_once("./helpers.php");  
?>
<?php
    try{
        if(!isset($_POST['date'])) throw new Exception('date was not set.');
        if(!isset($_POST['country'])) throw new Exception('country was not set.'); //should never execute since options have defaults
        if(!isset($_POST['newCases'])) throw new Exception('new cases were not set.');
        if(!isset($_POST['newDeaths'])) throw new Exception('new deaths were not set.');

        $country=$_POST['country'];
        $date=$_POST['date'];
        //When parsing the data from body it will all be of type string
        //In my database class I will check with my PDO the int types
        $new_cases=$_POST['newCases'];
        $new_deaths=$_POST['newDeaths'];
        
        $mysql_instance->insertNewCoronaStats($country,$date,$new_cases,$new_deaths);

        header('Location: ../index.php');
    }
    catch(Exception $e){
        displayErrorMessage($e);
    }

?>