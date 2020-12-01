<?php
    function render_last_covidstats(){
        $covidstats_rows=(MySQLDatabase::getMySqlDbh())->fetchLastStats();
        if (count($covidstats_rows)==0){
            print("<h1>No Countries Saved In Current Solution</h1>");
            return;
        }
        foreach($covidstats_rows as $row){
            render_last_covidstats_entry($row->countryId,$row->countryFlagFileName,$row->countryName,$row->lastCases,$row->lastDeaths);
        }
        }
    function render_last_covidstats_entry(string $countryId,string $countryFlagFileName,string $countryName, string $lastCases, string $lastDeaths){
        $detailsPath="../details/details.php?countryId=$countryId&countryName=$countryName&countryFlagFileName=$countryFlagFileName";
        print("
            <div class='covidstats-table__entry'>
                <div class='covidstats-table__entry--country-flag'><a href='$detailsPath'><img alt='$countryName flag' src='../shared/images/countriesFlags/$countryFlagFileName'/></a></div>
                <div class='covidstats-table__entry--country-name'><a href='$detailsPath'>$countryName</a></div>
                <div>$lastCases</div>
                <div>$lastDeaths</div>
            </div>
        ");
    }
?>
<?php include('../views/index/index.php');?>
