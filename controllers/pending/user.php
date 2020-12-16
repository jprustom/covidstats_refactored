<?php require_once('../../bootstrap.php');?>
<?php if (!$user->isAdmin)
        header('Location:../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php');?>
<?php \Library\Configs::generateHead('Error!','../../views/shared/images/icon.png',[
        "../../views/shared/main.css",
        "../../views/shared/navbar.css",
    ],[
        "homeLink"=>"../../views/statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../../views/statsCRUD.php",
        "countriesLink"=>"../../views/countriesCRUD/countriesCRUD.php",
        "signInLink"=>"../../views/auth/signIn.php",
        "memberSignUpLink"=>"../../views/auth/signUp.php",
        "signOutLink"=>"../auth/signout.php",
        "editProfileLink"=>"../../views/auth/editProfile.php",
        "pending"=>"../../views/pending/pending.php"
    ]) ?>
<?php
    try{
        if (!isset($_GET['action']))
            throw new Exception('action param was not provided');
        if (!isset($_GET['id']))
            throw new Exception('id param was not provided');
        $action=$_GET['action'];
        $userId=(int)($_GET['id']);
        if ($userId==0)
            throw new Exception('invalid user id');
        switch($action){
            case 'approve':
                \Models\User::approveUser($userId);
                break;
            case 'reject':
                \Models\User::rejectUser($userId);
                break;
            default:
                throw new Exception('invalid action, provide either reject or approve');
        }
        header('Location:../../views/pending/pending.php');
    }
    catch(Exception $e){
        \Library\Configs::displayErrorMessage($e);
    }
?>