<?php
    function get_last_covidstats_entry(string $countryId,string $countryFlagFileName,string $countryName, string $lastCases, string $lastDeaths){
        $detailsPath="../details/details.php?countryId=$countryId&countryName=$countryName&countryFlagFileName=$countryFlagFileName";
        return("
            <div class='covidstats-table__entry'>
                <div class='covidstats-table__entry--country-flag'><a href='$detailsPath'><img alt='$countryName flag' src='../shared/images/countriesFlags/$countryFlagFileName'/></a></div>
                <div class='covidstats-table__entry--country-name'><a href='$detailsPath'>$countryName</a></div>
                <div>$lastCases</div>
                <div>$lastDeaths</div>
            </div>
        ");
    }

    $covidstats_rows=CovidStats::fetchLastStats();
    $last_covidstats_entries='';
    if (count($covidstats_rows)==0){
        print("<h1>No Countries Saved In Current Solution</h1>");
        die();
    }
    foreach($covidstats_rows as $covidstat_row)
        $last_covidstats_entries.=get_last_covidstats_entry($covidstat_row->countryId,$covidstat_row->countryFlagFileName,$covidstat_row->countryName,$covidstat_row->lastCases,$covidstat_row->lastDeaths);

?>