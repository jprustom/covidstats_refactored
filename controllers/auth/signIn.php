<?php require_once('../../bootstrap.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../views/statsCRUD.php",
        "countriesLink"=>"../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "memberSignUpLink"=>"../../views/auth/signUp.php",
        "signOutLink"=>"signout.php",
        "editProfileLink"=>"../../views/auth/editProfile.php",
        "pending"=>"../../views/pending/pending.php"
    ]) ?>
<?php
    try{
        if (isset($_SESSION['user']))
            return header('Location:../../index.php');
        if (!isset($_POST['email']))
            throw new Exception('email was not provided');
        if (!isset($_POST['password']))
            throw new Exception('password was not provided');
        $email=$_POST['email'];
        $password=$_POST['password'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception('not a valid email format.');
        $user=\Models\User::loginUser($email,$password);
        $_SESSION['user']=$user;
        header('Location:../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>