
<?php require_once('../../bootstrap.php');?>
<?php if ($_SESSION['user'])
    header('Location:../statsCRUD/statsCRUD.php');?>
<?php Configs::generateHead('Sign In','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "admin.css"
    ],[
        "homeLink"=>"../statsCRUD/countries_last_stats_view/countries_last_stats_view.php",
        "statsLink"=>"../statsCRUD/statsCRUD.php",
        "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
        "signInLink"=>"",
        "signOutLink"=>"../../controllers/admin/signOut.php",
        "changePassLink"=>"../../controllers/admin/changePass.php"
    ]) ?>
<body>
    <h1>Sign In</h1>
    <form method="post" action="../../controllers/admin/signIn.php">
        <label required for="email">Email</label>
        <input type="email" name="email"/>
        <label for="password">Password</label>
        <input required type="password" name="password"/>
        <button type="submit">OK</button>
    </form>
</body>