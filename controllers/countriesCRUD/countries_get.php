
<?php
    try{
        $countries=\Models\Countries::fetchAllCountries();
        if (empty($countries))
            throw new Exception('no countries in database');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
?>