<?php require_once('../../bootstrap.php');?>
<?php if (!isset($_SESSION['user']) || !$user->isAdmin)
        header('Location:../../views/auth/signIn.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "memberSignUpLink"=>"../../views/auth/signUp.php",
        "signOutLink"=>"signout.php",
        "editProfileLink"=>"../../views/auth/editProfile.php",
        "pending"=>"../../views/pending/pending.php"
    ]) ?>
<?php 
    try{
        if (!isset($_POST['countryId']))
            throw new Exception('countryId not set');
        if (!isset($_POST['countryName']))
            throw new Exception('countryName not set');
        if (!isset($_FILES['newCountryFlag']) || !isset($_POST['originalCountryFlagFileName']))
            throw new Exception('missing country flag data in form');
        $countryName=$_POST['countryName'];
        if (trim($countryName)==='')
            throw new Exception('country name cannot be empty');
        $countryId=$_POST['countryId'];
        $initialCountryFlagFileName=$_POST['originalCountryFlagFileName'];
        $newCountryFlag=$_FILES['newCountryFlag'];
        $newCountryFlagFileName=$newCountryFlag['name'];
        $isNewCountryFlagProvided=trim($newCountryFlag['name'])!=='';
        \Models\Countries::updateCountry($countryId,$countryName,$isNewCountryFlagProvided?$newCountryFlagFileName:$initialCountryFlagFileName);
        if ($isNewCountryFlagProvided){
            unlink("../../views/shared/images/countriesFlags/$initialCountryFlagFileName");
            $newCountryFlagFileName=uniqid().'_'.$newCountryFlagFileName;
            $newCountryFlagTempName=$newCountryFlag['tmp_name'];
            move_uploaded_file($newCountryFlagTempName,'../../views/shared/images/countriesFlags/'.$newCountryFlagFileName);
        }
        header('Location:../../views/countriesCRUD/countriesCRUD.php');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
    

?>