
<?php if (!$_SESSION['user'])
        header('Location:../../views/admin/signIn.php');?>
<?php
    try{
        $countries=Countries::fetchAllCountries();
        if (empty($countries))
            throw new Exception('no countries in database');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }
?>