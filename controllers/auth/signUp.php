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
        if (isset($SESSION['user']))
            return header('Location:../../indexphp');
        if (!isset($_POST['username']))
            throw new Exception('username was not set');
        if (!isset($_POST['email']))
            throw new Exception('email was not provided');
        if (!isset($_POST['password']))
            throw new Exception('password was not provided');
        if (!isset($_POST['confirmPassword']))
            throw new Exception('confirm password was not provided');
        if (!isset($_POST['phoneNumber']))
            throw new Exception('telephone number was not provided');
        $email=$_POST['email'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        if (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+){8,}$/',$password))
            throw new Exception('password must be at least 8 characters, and alphanumeric');
        $confirmPassword=$_POST['confirmPassword'];
        $phoneNumber=$_POST['phoneNumber'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            throw new Exception('not a valid email format.');
        $email=filter_var($email, FILTER_SANITIZE_EMAIL);
        if ($password!==$confirmPassword)
            throw new Exception('passwords do not match');
        if (!preg_match(
                '/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|
                2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|
                4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/',
                $phoneNumber))
                    throw new Exception('invalid phone number format');
        $user=\Models\User::signUpUser($username,$email,$phoneNumber,$password);
        $_SESSION['user']=$user;
        header('Location:../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }

?>