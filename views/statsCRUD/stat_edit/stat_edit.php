<?php require_once('../../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../../admin/signIn.php');?>
<?php \Library\Configs::generateHead('Edit Stat','../../shared/images/icon.png',[
    "../../shared/main.css",
    "../../shared/navbar.css",
    "./stat_edit.css"
],[
    "homeLink"=>"../countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../statsCRUD.php",
    "countriesLink"=>"../../countriesCRUD/countriesCRUD.php",
    "signInLink"=>"../../admin/signIn.php",
    "memberSignUpLink"=>"../../admin/signUp.php",
    "signOutLink"=>"../../../controllers/admin/signOut.php",
    "changePassLink"=>"../../admin/changePass.php"
]) ?>
<?php require_once('../../../controllers/countriesCRUD/countries_get.php'); ?>
<?php require_once('../../../controllers/statsCRUD/stat_get.php');?>
<body>
    <h1>Edit Stat Number <?php echo($statId)?></h1>
    <form id="edit-stats" action="../../../controllers/statsCRUD/stat_edit.php"  method='post'>
        <input type="hidden" name="statId" value='<?php echo($statId) ?>' />
        <div id='date'>
            <label for='date'>Date:</label>
            <!-- I could have edited a date type, but the specific format dd-mm-YYYY is required -->
            <!-- The following regex is simple and basic, for simplicity purpose -->
            <input required name='date' value='<?php echo( $initialStatDate )?>' placeholder="dd-mmmm-YYYY" maxlength="11" pattern="^(0[1-9]|[12][0-9]|3[01])[- -.](Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[- -.](19|20)\d\d$" type='text'/>
        </div>
        <div id='country'>
            <label for='country'>Country:</label>
            <select required name='countryId'>
                <?php
                    foreach($countries as $countryObj){
                        $countryId=$countryObj->id;
                        $selected=$countryId==$initialStatCountryId?"selected='selected'":"";
                        $countryName=$countryObj->countryName;
                        $countryName=ucwords($countryObj->countryName) ;
                        print("
                            <option $selected value='$countryId'>
                                $countryName 
                            </option>
                        ");
                    }
                ?>
            </select>
        </div>
        <div id='newCases'>
            <label for='newCases'>Number of new cases:</label>
            <input name='newCases' value='<?php echo($initialStatCases) ?>' required min=0 type='number'/>
        </div>
        <div id='newDeaths'>
            <label for='newDeaths'>Number of new deaths:</label>
            <input name='newDeaths' value='<?php echo($initialStatDeaths) ?>' required min=0 type='number'/>
        </div>
        <button type='submit'>Save Changes</button>
        <button type='reset'>Reset</button>
    </form>
</body>
</html>