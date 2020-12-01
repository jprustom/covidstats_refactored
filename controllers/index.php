<?php
    $covidstats_rows=CovidStats::fetchLastStats();
    if (count($covidstats_rows)==0){
        print("<h1>No Countries Saved In Current Solution</h1>");
        die();
    }
?>