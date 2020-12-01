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
        if (!isset($_SESSION['user']))
            return header('Location:../../views/auth/signIn.php');
        $user=$_SESSION['user'];
        if (!isset($user['email']))
            return header('Location:../../views/auth/signIn.php');
        $email=$user['email'];
        if (!isset($_POST['oldPassword']))
            throw new Exception('old password was not provided');
        if (!isset($_POST['newPassword']))
            throw new Exception('new password was not provided');
        if (!isset($_POST['confirmNewPassword']))
            throw new Exception('confirmed password was not provided');

        $oldPassword=$_POST['oldPassword'];
        if (sha1($oldPassword)!==$user['password'])
            throw new Exception('old password is incorrect');
        $newPassword=$_POST['newPassword'];
        $confirmNewPassword=$_POST['confirmNewPassword'];
        if ($newPassword!==$confirmNewPassword)
            throw new Exception('Passwords Do Not Match');
        User::updateUserPassword($email,$newPassword);
        $_SESSION['user']=[
            "email"=>$email,
            "password"=>sha1($newPassword)
        ];
        header('Location:../../views/index/index.php');
    }
    catch(Exception $e){
        Configs::displayErrorMessage($e);
    }

?>