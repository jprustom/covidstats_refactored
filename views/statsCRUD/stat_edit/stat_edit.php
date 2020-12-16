<?php require_once('../../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../../auth/signIn.php');?>
<?php \Library\Configs::generateHead('Edit Stat','../../shared/images/icon.png',[
    "../../shared/main.css",
    "../../shared/navbar.css",
    "./stat_edit.css"
],[
    "homeLink"=>"../countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../statsCRUD.php",
    "countriesLink"=>"../../countriesCRUD/countriesCRUD.php",
    "signInLink"=>"../../auth/signIn.php",
    "memberSignUpLink"=>"../../auth/signUp.php",
    "signOutLink"=>"../../../controllers/auth/signOut.php",
    "editProfileLink"=>"../../auth/editProfile.php",
    "pending"=>"../../pending/pending.php"
]) ?>
<?php require_once('../../../controllers/countriesCRUD/countries_get.php'); ?>
<?php require_once('../../../controllers/statsCRUD/stat_get.php');?>
<body>
    <h1 style="text-decoration: underline;">Edit Stat Number <?php echo($statId)?></h1>
    <form id="edit-stats" action="../../../controllers/statsCRUD/stat_edit.php"  method='post'>
        <input type="hidden" name="statId" value='<?php echo($statId) ?>' />
        <input type="hidden" name="countryId" value='<?php echo($initialStatCountryId) ?>' />
        <div id='date'><h1><?php echo($initialStatDate); ?></h1></div>
        <div id='country'>
                <?php
                    foreach($countries as $countryObj){
                        $countryId=$countryObj->id;
                        if($countryId==$initialStatCountryId){
                            $countryName=ucwords($countryObj->countryName) ;
                            print("<h1>$countryName</h1>");
                            break;
                        }
                    }
                ?>
        </div>
        <div id='newCases'>
            <label for='newCases'>Number of new cases:</label>
            <input name='newCases' value='<?php echo($initialStatCases) ?>' required min=0 type='number'/>
        </div>
        <div id='newDeaths'>
            <label for='newDeaths'>Number of new deaths:</label>
            <input name='newDeaths' value='<?php echo($initialStatDeaths) ?>' required min=0 type='number'/>
        </div>
        <button type='submit'><?php if ($user->isAdmin) echo("Save"); else echo("Request"); ?> Changes</button>
        <button type='reset'>Reset</button>
    </form>
</body>
</html>