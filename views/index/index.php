
<html>
    <?php require_once("../../bootstrap.php") ?>
    <?php Configs::generateHead('Last Stats','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "index.css"
    ],[
        "homeLink"=>"",
        "addStatsLink"=>"../add/add.php",
        "addCountryLink"=>"../add_country/add_country.php"
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
                <?php echo($last_covidstats_entries) ?>
            </div>
            
        </section>
    </body>
</html>