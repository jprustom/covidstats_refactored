<?php require_once('../../bootstrap.php'); ?>
<?php if (!isset($_SESSION['user']))
    return header('Location:../auth/signIn.php');?>

<?php \Library\Configs::generateHead('Stats','../shared/images/icon.png',[
    "../shared/main.css",
    "../shared/navbar.css",
    "statsCRUD.css"
],[
    "homeLink"=>"countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"statsCRUD.php",
    "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
    "signInLink"=>"../auth/signIn.php",
    "memberSignUpLink"=>"../auth/signUp.php",
    "signOutLink"=>"../../controllers/auth/signOut.php",
    "editProfileLink"=>"../auth/editProfile.php",
    "pending"=>"../pending/pending.php"
]) ?>

<?php require_once('../../controllers/countriesCRUD/country_get_stats.php');?>

<body>
    <a id="addStat" href='<?php echo("country_add_stat/country_add_stat.php?countryId=$countryId")?>'>Add Stats</a>
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
    <?php 
        $user=$_SESSION['user'];
        $isAdmin=$user->isAdmin;
        $isAccepted=$user->isAccepted;
        if (!$isAccepted){
                echo("not accepted");die();
                header('Location:./countries_view_last_stats/countries_view_last_stats.php');}
    ?>
    <?php $numberOfColumns=
            $isAdmin
                ?'five-columns'
                :'four-columns'?>
    <section id="statsCRUD-table">
        <div id="statsCRUD-table__headers">
            <div class="statsCRUD-table__header <?php echo($numberOfColumns) ?>">Date</div>
            <div class="statsCRUD-table__header <?php echo($numberOfColumns) ?>">Cases</div>
            <div class="statsCRUD-table__header <?php echo($numberOfColumns) ?>">Deaths</div>
            <div class="statsCRUD-table__header <?php echo($numberOfColumns) ?>">Edit<?php if ($isAdmin) echo("/Delete"); ?></div>
            <?php 
                if ($isAdmin)
                    echo("<div class='statsCRUD-table__header $numberOfColumns'>Posted By User</div>")
            ?>
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
                        $username=\Models\User::getUsername($countryStat->userId);
                        if ($isAdmin){
                            $deleteStatEntry="/<a href='../../controllers/statsCRUD/stat_delete.php?statId=$statId&countryId=$countryId'>Delete</a>";
                            $usernameEntry="<div>$username</div>";
                        }
                        else {
                            $deleteStatEntry=null;
                            $usernameEntry=null;
                        }
                        print("
                            <div class='statsCRUD-table__entry $numberOfColumns'>
                                <div>$date</div>
                                <div>$cases</div>
                                <div>$deaths</div>
                                <div><a href='stat_edit/stat_edit.php?statId=$statId'>Edit</a>$deleteStatEntry</div>
                                $usernameEntry
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