<?php require_once('../../bootstrap.php');?>
<?php Configs::generateHead('Change Password','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "auth.css"
    ],[
        "homeLink"=>"../index/index.php",
        "addStatsLink"=>"../add/add.php",
        "addCountryLink"=>"../add_country/add_country.php",
        "signUpLink"=>"",
        "signInLink"=>"signIn.php",
        "signOutLink"=>"../../controllers/auth/signOut.php",
        "changePassLink"=>""
    ]) ?>
<body>
<h1>Change Password </h1>
    <form method="post" action="../../controllers/auth/changePass.php">
        <label for="oldPassword">Old Password</label>
        <input required  type="password" name="oldPassword"/>
        <label for="newPassword">New Password</label>
        <input required minlength="5" maxlength="15" type="password" name="newPassword"/>
        <label for="confirmNewPassword">Confirm Password</label>
        <input required minlength="5" maxlength="15" type="password" name="confirmNewPassword"/>
        <button type="submit">OK</button>
    </form>
</body>