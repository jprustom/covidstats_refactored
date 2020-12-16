
<?php require_once('../../bootstrap.php');?>
<?php if (isset($_SESSION['user']))
    header('Location:../statsCRUD/statsCRUD.php');?>
<?php \Library\Configs::generateHead('Sign In','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "auth.css"
    ],[
        "homeLink"=>"../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../statsCRUD/statsCRUD.php",
        "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
        "signInLink"=>"",
        "memberSignUpLink"=>"signUp.php",
        "signOutLink"=>"../../controllers/auth/signOut.php",
        "editProfileLink"=>"../../controllers/auth/editProfile.php",
        "pending"=>"../pending/pending.php"
    ]) ?>
<body>
    <h1>Sign In</h1>
    <form method="post" action="../../controllers/auth/signIn.php">
        <label required for="email">Email</label>
        <input type="email" placeholder="example@example.com" name="email"/>
        <label for="password">Password</label>
        <input required type="password" name="password"/>
        <button type="submit">OK</button>
    </form>
</body>