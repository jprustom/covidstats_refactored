<?php include('../../bootstrap.php');?>
<?php Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/index/index.php",
        "addStatsLink"=>"../views/add/add.php",
        "addCountryLink"=>"../views/add_country/add_country.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "signUpLink"=>"../../views/auth/signUp.php",
        "signOutLink"=>"signout.php",
        "changePassLink"=>"../../views/auth/changePass.php"
    ]) ?>
<?php
    try{
        if (!isset($_POST['email']))
        throw new Exception('email was not provided');
        if (!isset($_POST['password']))
            throw new Exception('password was not provided');
        if (!isset($_POST['confirmPassword']))
            throw new Exception('confirmed password was not provided');
        $email=$_POST['email'];
        $password=$_POST['password'];
        $confirmPassword=$_POST['confirmPassword'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception('not a valid email format.');
        if ($password!==$confirmPassword)
            throw new Exception('Passwords Do Not Match');
        User::createUser($email,$password);
        $_SESSION['user']=[
            "email"=>$email
        ];
        header('Location:../../views/index/index.php');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }

?>