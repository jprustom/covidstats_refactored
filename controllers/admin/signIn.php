<?php require_once('../../bootstrap.php');?>
<?php Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_last_stats_view/countries_last_stats_view.php",
        "statsLink"=>"../views/statsCRUD.php",
        "countriesLink"=>"../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/admin/signIn.php",
        "signOutLink"=>"signout.php",
        "changePassLink"=>"../../views/admin/changePass.php"
    ]) ?>
<?php
    try{
        if (!isset($_POST['email']))
        throw new Exception('email was not provided');
        if (!isset($_POST['password']))
            throw new Exception('password was not provided');
        $email=$_POST['email'];
        $password=$_POST['password'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception('not a valid email format.');

        User::loginUser($email,$password);
        $_SESSION['user']=[
            "email"=>$email,
            "password"=>sha1($password)
        ];
        header('Location:../../views/statsCRUD/countries_last_stats_view/countries_last_stats_view.php');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }

?>