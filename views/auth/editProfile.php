<?php require_once('../../bootstrap.php');?>
<?php if (!$_SESSION['user'])
    header('Location:signIn.php');?>
<?php \Library\Configs::generateHead('Edit Profile','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "auth.css"
    ],[
        "homeLink"=>"../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../statsCRUD/statsCRUD.php",
        "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
        "signInLink"=>"signIn.php",
        "memberSignUpLink"=>"signUp.php",
        "signOutLink"=>"../../controllers/auth/signOut.php",
        "editProfileLink"=>"",
        "pending"=>"../pending/pending.php"
    ]) ?>
<body>
<h1>Edit Profile </h1>
    <form method="post" action="../../controllers/auth/editProfile.php">
        <label for="username">Username</label>
        <input name="username" type="text" value='<?php echo($user->username)?>'/>
        <label for="oldPassword">Old Password</label>
        <input required  type="password" name="oldPassword"/>
        <label for="newPassword">New Password</label>
        <input required minlength="5" maxlength="15" type="password" name="newPassword"/>
        <label for="confirmNewPassword">Confirm Password</label>
        <input required minlength="5" maxlength="15" type="password" name="confirmNewPassword"/>
        <button type="submit">OK</button>
    </form>
</body>