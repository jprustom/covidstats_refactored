
<html>
    <?php require_once("../../bootstrap.php") ?>
    <?php Configs::generateHead('Last Stats','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "index.css"
    ],[
        "homeLink"=>"",
        "addStatsLink"=>"../add/add.php",
        "addCountryLink"=>"../add_country/add_country.php",
        "signInLink"=>"../auth/signIn.php",
        "signUpLink"=>"../auth/signUp.php",
        "signOutLink"=>"../../controllers/auth/signOut.php",
        "changePassLink"=>"../auth/changePass.php"
    ]) ?>
    <?php include_once('../../controllers/index.php');?>
    <body>
    <h1>Latest Covid Stats</h1>
        <section id="covidstats-table">
            <div id="covidstats-table__headers">
                <div class="covidstats-table__header"></div>
                <div class="covidstats-table__header">Country</div>
                <div class="covidstats-table__header">Latest Cases</div>
                <div class="covidstats-table__header">Latest Deaths</div>
            </div>
            <div id="covidstats-table__entries">
                <?php 
                    foreach($covidstats_rows as $covidstat_row){
                        $countryId=$covidstat_row->countryId;
                        $countryFlagFileName=$covidstat_row->countryFlagFileName;
                        $countryName=$covidstat_row->countryName;
                        $lastCases=$covidstat_row->lastCases;
                        $lastDeaths=$covidstat_row->lastDeaths;
                        $detailsPath="../details/details.php?countryId=$countryId&countryName=$countryName&countryFlagFileName=$countryFlagFileName";
                        print("
                            <div class='covidstats-table__entry'>
                                <div class='covidstats-table__entry--country-flag'><a href='$detailsPath'><img alt='$countryName flag' src='../shared/images/countriesFlags/$countryFlagFileName'/></a></div>
                                <div class='covidstats-table__entry--country-name'><a href='$detailsPath'>$countryName</a></div>
                                <div>$lastCases</div>
                                <div>$lastDeaths</div>
                            </div>
                        ");
                    };
                ?>
            </div>
            
        </section>
    </body>
</html>