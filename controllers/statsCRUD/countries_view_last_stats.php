<?php
    $covidstats_rows=\Models\CovidStats::fetchLastStats();
    if (count($covidstats_rows)==0){
        print("<h1>No \Models\Countries Saved In Current Solution</h1>");
        die();
    }
?>