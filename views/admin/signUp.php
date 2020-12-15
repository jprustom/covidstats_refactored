
<?php require_once('../../bootstrap.php');?>
<?php if (isset($_SESSION['user']))
    header('Location:../statsCRUD/statsCRUD.php');?>
<?php \Library\Configs::generateHead('Sign Up','../shared/images/icon.png',[
        "../shared/main.css",
        "../shared/navbar.css",
        "admin.css"
    ],[
        "homeLink"=>"../statsCRUD/countries_view_last_stats/countries_view_last_stats.php",
        "statsLink"=>"../statsCRUD/statsCRUD.php",
        "countriesLink"=>"../countriesCRUD/countriesCRUD.php",
        "signInLink"=>"signIn.php",
        "memberSignUpLink"=>"",
        "signOutLink"=>"../../controllers/admin/signOut.php",
        "changePassLink"=>"../../controllers/admin/changePass.php"
    ]) ?>
<body>
    <h1>Sign Up</h1>
    <form method="post" action="../../controllers/admin/signUp.php">
        <label required for="email">Email</label>
        <input type="email" placeholder="example@example.com" name="email"/>
        <label for="phoneNumber">Phone Number</label>
        <input required 
            placeholder="+96112345678"
            type="tel" 
            pattern="\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|
                    2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|
                    4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$" 
            name="phoneNumber"/>
        <label for="password">Password</label>
        <input minlength="8" required type="password" pattern="^(?=.*[0-9])(?=.*[a-zA-Z])([a-zA-Z0-9]+){8,}$" name="password"/>
        <label for="confirmPassword">Confirm Password</label>
        <input minlength="8" required type="password" name="confirmPassword"/>
        <button type="submit">OK</button>
    </form>
</body>