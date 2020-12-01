<?php require_once('../../bootstrap.php');?>
<?php Configs::generateHead('Sign Up','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "auth.css"
    ],[
        "homeLink"=>"../index/index.php",
        "addStatsLink"=>"../add/add.php",
        "addCountryLink"=>"../add_country/add_country.php",
        "signUpLink"=>"",
        "signInLink"=>"signIn.php",
        "signOutLink"=>"signOut.php",
        "changePassLink"=>"changePass.php"
    ]) ?>
<body>
<h1>Sign Up </h1>
    <form method="post" action="../../controllers/auth/signUp.php">
        <label for="email">Email</label>
        <input required type="email" name="email"/>
        <label for="password">Password</label>
        <input minlength="5" required maxlength="15" type="password" name="password"/>
        <label for="confirmPassword">Confirm Password</label>
        <input required maxlength="15" type="password" name="confirmPassword"/>
        <button type="submit">OK</button>
    </form>
</body>