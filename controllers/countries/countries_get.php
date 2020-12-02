<?php if (!$_SESSION['user'])
        header('Location:../../views/admin/signIn.php');?>
<?php
    try{
        $countries=Countries::fetchAllCountries();
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>