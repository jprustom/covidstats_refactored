<?php require_once('../../bootstrap.php'); ?>
<?php if (!$_SESSION['user'])
    header('Location:../admin/signIn.php');?>
<?php Configs::generateHead('Countries','../shared/images/icon.png',[
    "../shared/main.css",
    "../shared/navbar.css",
    "countriesCRUD.css"
],[
    "homeLink"=>"../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
    "statsLink"=>"../statsCRUD/statsCRUD.php",
    "countriesLink"=>"",
    "signInLink"=>"../admin/signIn.php",
    "signOutLink"=>"../../controllers/admin/signOut.php",
    "changePassLink"=>"../admin/changePass.php"
]) ?>
<?php require_once('../../controllers/countriesCRUD/countries_get.php');?>
<a id="addCountry" href='country_add/country_add.php'>Add Country</a>
<section id="countriesCRUD-table">
    <div id="countriesCRUD-table__headers">
                <div class="countriesCRUD-table__header">Name</div>
                <div class="countriesCRUD-table__header">Id</div>
                <div class="countriesCRUD-table__header">Flag</div>
                <div class="countriesCRUD-table__header">Edit</div>
                <div class="countriesCRUD-table__header">Delete</div>
    </div>
    <div id="countriesCRUD-table__entries">
        <?php 
            foreach($countries as $country){
                $countryId=$country->id;
                $countryFlagFileName=$country->countryFlagFilename;
                $countryName=$country->countryName;
                $detailsPath="../statsCRUD/country_view_stats/country_view_stats.php?countryId=$countryId&countryName=$countryName&countryFlagFileName=$countryFlagFileName";
                print("
                    <div class='countriesCRUD-table__entry'>
                        <div class='countriesCRUD-table__entry--country-name'><a href='$detailsPath'>$countryName</a></div>
                        <div class='countriesCRUD-table__entry'>$countryId</div>
                        <div class='countriesCRUD-table__entry--country-flag'><a href='$detailsPath'><img alt='flag' src='../shared/images/countriesFlags/$countryFlagFileName'/></a></div>
                        <div class='countriesCRUD-table__entry'><a href='../../views/countriesCRUD/country_edit/country_edit.php?countryId=$countryId'>Edit</a></div>
                        <div class='countriesCRUD-table__entry'><a href='../../controllers/countriesCRUD/country_delete.php?countryId=$countryId&countryFlagFileName=$countryFlagFileName'>Delete</a></div>
                    </div>
                ");
            };
    ?>
    </div>
</section>