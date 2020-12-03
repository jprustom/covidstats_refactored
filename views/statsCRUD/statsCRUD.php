<?php require_once('../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../admin/signIn.php');?>
<?php Configs::generateHead('Stats','../shared/images/icon.png',[
    "../shared/main.css",
    "../shared/navbar.css",
    "statsCRUD.css"
],[
    "homeLink"=>"countries_last_stats_view/countries_last_stats_view.php",
    "statsLink"=>"statsCRUD.php",
    "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
    "signInLink"=>"../admin/signIn.php",
    "signOutLink"=>"../../controllers/admin/signOut.php",
    "changePassLink"=>"../admin/changePass.php"
]) ?>

<?php require_once('../../controllers/countriesCRUD/country_get_stats.php');?>
<body>
    <a id="addStat" href='country_add_stat/country_add_stat.php'>Add Stats</a>
    <div id='selectCountry'>
        <label for='country'>Country:</label>
        <select required name='country'>
            <?php
                foreach($countries as $countryObj){
                    $countryId=$countryObj->id;
                    $selected=$countryId===$_GET['countryId']?"selected='selected'":"";
                    $countryName=$countryObj->countryName;
                    $countryNameToDisplay=ucwords($countryObj->countryName) ;
                    print("
                        <option $selected value='$countryId'>
                            $countryNameToDisplay 
                        </option>
                    ");
                }
            ?>
        </select>
        </div>
    
    <section id="statsCRUD-table">
        <div id="statsCRUD-table__headers">
            <div class="statsCRUD-table__header">Date</div>
            <div class="statsCRUD-table__header">Cases</div>
            <div class="statsCRUD-table__header">Deaths</div>
            <div class="statsCRUD-table__header">Edit</div>
            <div class="statsCRUD-table__header">Delete</div>
        </div>
        <div id="covidstats-table__entries">
            <?php
                if (empty($countryStats)){
                    print("
                        <h1>No Stats. Click the topmost button above to add some stats.</h1>
                    ");
                }
                else {
                    foreach($countryStats as $countryStat){
                        $countryId=$countryStat->countryId;
                        $statId=$countryStat->id;
                        $date=$countryStat->date;
                        $cases=$countryStat->lastCases;
                        $deaths=$countryStat->lastDeaths;
                        print("
                        <div class='statsCRUD-table__entry'>
                            <div class='statsCRUD-table__entry'>$date</div>
                            <div class='statsCRUD-table__entry'>$cases</div>
                            <div class='statsCRUD-table__entry'>$deaths</div>
                            <div class='statsCRUD-table__entry'><a href='stat_edit/stat_edit.php?statId=$statId'>Edit</a></div>
                            <div class='statsCRUD-table__entry'><a href='../../controllers/statsCRUD/stat_delete.php?statId=$statId&countryId=$countryId'>Delete</a></div>
                        </div>
                        ");
                    }
                }
            ?>
        </div>
    </section>
</body>

<script>
    const select=document.querySelector('select');
    const pageUrl=window.location.protocol+window.location.port+'//'+window.location.hostname+window.location.pathname
    select.addEventListener('change',function(event){
        window.location.assign(`${pageUrl}?countryId=${select.value}`);
    });
</script>