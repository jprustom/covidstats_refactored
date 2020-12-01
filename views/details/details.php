<?php require_once('../../bootstrap.php'); ?>

<?php Configs::generateHead('Details','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css"
],[
    "homeLink"=>"../index/index.php",
    "addStatsLink"=>"../add/add.php",
    "addCountryLink"=>"../add_country/add_country.php"
]) ?>
<?php 
    try{
        if(!isset($_GET['countryId']))
            throw new Exception('country id not found!');
        $countryId=$_GET['countryId'];

        $countryName=$_GET['countryName'];
        $countryFlagFileName=$_GET['countryFlagFileName'];
        $countryFlagImagePath="../images/countriesFlags/$countryFlagFileName";
        $countryStats=(MySQLDatabase::getMySqlDbh())->fetchCountryStats((int)($_GET['countryId']));
    }
    catch(Exception $e){
        print($e->getMessage());
    }
?>
<body>
    <h1><?php echo($_GET['countryName']) ?></h1>
    <img id='countryFlag' alt="Flag" src=<?php echo($countryFlagImagePath) ?> />
    <ul>
        <?php 
            //I chose this method instead of running another unecessary query
            $totalCases=0;
            $totalDeaths=0;
            foreach ($countryStats as $countryStat){
                $date=$countryStat->date;
                $date=date("d F Y", strtotime($date));
                $cases=$countryStat->lastCases;
                $deaths=$countryStat->lastDeaths;

                $totalCases+=$cases;
                $totalDeaths+=$deaths;

                print("
                    <li>
                        <h4>On $date:</h4>
                        <h3>$cases New Cases & $deaths Dead</h3>
                    </li>    
                ");
            }
        ?>
    </ul>
    <h1>Total:<?php echo($totalCases)?> Cases & <?php echo($totalDeaths)?> Deaths.</h1>
</body>
</html>