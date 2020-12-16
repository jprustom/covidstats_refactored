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
        if (!isset($_SESSION['user']))
            return header('Location:../../views/auth/signIn.php');
        $user=$_SESSION['user'];
        if (!isset($_POST['username']))
            throw new Exception('no username provided');
        $username=$_POST['username'];
        $email=$user->email;
        if (!isset($_POST['oldPassword']))
            throw new Exception('old password was not provided');
        if (!isset($_POST['newPassword']))
            throw new Exception('new password was not provided');
        if (!isset($_POST['confirmNewPassword']))
            throw new Exception('confirmed password was not provided');

        $oldPassword=$_POST['oldPassword'];
        if (sha1($oldPassword)!==$user->password)
            throw new Exception('old password is incorrect');
        $newPassword=$_POST['newPassword'];
        $confirmNewPassword=$_POST['confirmNewPassword'];
        if ($newPassword!==$confirmNewPassword)
            throw new Exception('Passwords Do Not Match');
        \Models\User::updateUser($email,$newPassword,$username);
        $user->password=sha1($newPassword);
        $_SESSION['user']=$user;
        header('Location:../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>