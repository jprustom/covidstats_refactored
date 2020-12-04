<?php require_once('../../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../../admin/signIn.php');?>
<?php \Library\Configs::generateHead('Add Country','../../shared/images/icon.png',[
    "../../shared/main.css",
    "../../shared/navbar.css",
    "country_add.css"
],[
    "homeLink"=>"../../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../../statsCRUD/statsCRUD.php",
    "countriesLink"=>"../countriesCRUD.php",
    "signInLink"=>"../../admin/signIn.php",
    "signOutLink"=>"../../../controllers/admin/signOut.php",
    "changePassLink"=>"../../admin/changePass.php"
]) ?>
    <body>
        <h1>Please enter below the country to be added</h1>
        <form method="post" enctype="multipart/form-data" action="../../../controllers/countriesCRUD/country_insert.php">
            <input required name="countryFlag" type="file"/>
            <button id="uploadFlagBtn">Upload Country Flag</button>
            <label for="countryName">Country Name:</label>
            <input required name="countryName" type="text"/>
            <button name="submit" type="submit">OK</button>
        </form>
        <script>
            const originalUploadFlagBtn=document.querySelector('form>input');
            const uploadFlagBtn=document.getElementById('uploadFlagBtn');
            uploadFlagBtn.addEventListener('click',(event)=>{
                event.preventDefault();
                originalUploadFlagBtn.click();
                });
        </script>
    </body>
</html>
