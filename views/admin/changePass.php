<?php require_once('../../bootstrap.php');?>
<?php Configs::generateHead('Change Password','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "admin.css"
    ],[
        "homeLink"=>"../index/index.php",
        "statsLink"=>"../add/add.php",
        "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
        "signInLink"=>"signIn.php",
        "signOutLink"=>"../../controllers/admin/signOut.php",
        "changePassLink"=>""
    ]) ?>
<body>
<h1>Change Password </h1>
    <form method="post" action="../../controllers/admin/changePass.php">
        <label for="oldPassword">Old Password</label>
        <input required  type="password" name="oldPassword"/>
        <label for="newPassword">New Password</label>
        <input required minlength="5" maxlength="15" type="password" name="newPassword"/>
        <label for="confirmNewPassword">Confirm Password</label>
        <input required minlength="5" maxlength="15" type="password" name="confirmNewPassword"/>
        <button type="submit">OK</button>
    </form>
</body>