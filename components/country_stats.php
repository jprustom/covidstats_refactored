<?php
    $countryName=$_GET['countryName'];
    $countryFlagFileName=$_GET['countryFlagFileName'];
    $countryFlagImagePath="../images/countriesFlags/$countryFlagFileName";
    $countryStats=$mysql_instance->fetchCountryStats($_GET['countryId']);
?>
<body>
    <h1><?php echo($_GET['countryName']) ?></h1>
    <img id='countryFlag' src=<?php echo($countryFlagImagePath) ?> />
    <ul>
        <?php 
            //I chose this method instead of running another unecessary query
            $totalCases=0;
            $totalDeaths=0;
            foreach ($countryStats as $countryStat){
                $date=$countryStat->date;
                $date=date("m-d-Y", strtotime($date));
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