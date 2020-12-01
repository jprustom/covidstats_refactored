<?php require_once('../../bootstrap.php');?>
<?php Configs::generateHead('Sign In','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "auth.css"
    ],[
        "homeLink"=>"../index/index.php",
        "addStatsLink"=>"../add/add.php",
        "addCountryLink"=>"../add_country/add_country.php",
        "signInLink"=>"",
        "signUpLink"=>"signUp.php",
        "signOutLink"=>"../../controllers/auth/signOut.php",
        "changePassLink"=>"../../controllers/auth/changePass.php"
    ]) ?>
<body>
    <h1>Sign In</h1>
    <form method="post" action="../../controllers/auth/signIn.php">
        <label required for="email">Email</label>
        <input type="email" name="email"/>
        <label for="password">Password</label>
        <input required type="password" name="password"/>
        <button type="submit">OK</button>
    </form>
</body>