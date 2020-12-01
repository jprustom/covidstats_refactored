<?php if (!$_SESSION['user'])
        header('Location:../views/auth/signIn.php');?>
<?php
    try{
        $countryObjArray=Countries::fetchAllCountries();
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>