<?php require_once('../../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../../auth/signIn.php');?>
<?php \Library\Configs::generateHead('Edit Country','../../shared/images/icon.png',[
    "../../shared/main.css",
    "../../shared/navbar.css",
    "country_edit.css"
],[
    "homeLink"=>"../../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../../statsCRUD/statsCRUD.php",
    "countriesLink"=>"../countriesCRUD.php",
    "signInLink"=>"../../auth/signIn.php",
    "memberSignUpLink"=>"../../auth/signUp.php",
    "signOutLink"=>"../../../controllers/auth/signOut.php",
    "editProfileLink"=>"../../auth/editProfile.php",
    "pending"=>"../../pending/pending.php"
]) ?>
<?php require_once('../../../controllers/countriesCRUD/country_get.php');?>
<body>
    <form enctype="multipart/form-data" method="POST" action='<?php echo("../../../controllers/countriesCRUD/country_edit.php")?>'>
        <h1><?php echo("Edit $countryName")?></h1>
        <input name="countryName" value='<?php echo $countryName ?>'/>
        <img src='<?php echo("../../shared/images/countriesFlags/$countryFlagFileName") ?>'/>
        <button id='uploadFlagBtn'>Change Picture</button>
        <input type="file" name="newCountryFlag"/>
        <input type="hidden" name='originalCountryFlagFileName' value='<?php echo($countryFlagFileName) ?>'/>
        <input type="hidden" name="countryId" value='<?php echo($countryId)?>'?>
        <button type='submit'>Save</button>
        <button type="reset">Reset</button>
    </form>
</body>
<script>
    const originalUploadFlagBtn=document.querySelector("form>input[type='file']");
    const uploadFlagBtn=document.getElementById('uploadFlagBtn');
    uploadFlagBtn.addEventListener('click',(event)=>{
        event.preventDefault();
        originalUploadFlagBtn.click();
        });
</script>