<?php namespace Library;
    class Configs{
        public static $coronastats_db_config=[
            "host"=>'localhost',
            "database"=>'coronavirus_refactored',
            "username"=>'root',
            "password"=>''
        ];
        private static function generateNavBar(string $navbarIconPath,array $navbarLinks){
            $homeLink=$navbarLinks['homeLink'];
            $statsLink=$navbarLinks['statsLink'];
            $countriesLink=$navbarLinks['countriesLink'];
            $signInLink=$navbarLinks['signInLink'];
            $signOutLink=$navbarLinks['signOutLink'];
            $memberSignUpLink=$navbarLinks['memberSignUpLink'];
            $editProfileLink=$navbarLinks['editProfileLink'];
            $pendingLink=$navbarLinks['pending'];
            $imageClick="<script>
                            document.querySelector('#navbar>img').addEventListener('click',()=>{
                                document.getElementById('home').click();
                            });
                        </script>
                        ";
            
            if (isset($_SESSION['user'])){
                $user=$_SESSION['user'];
                if ($user->isAdmin)
                        return ( //If Admin
                            "   
                                <section id='navbar'>
                                    <img src=$navbarIconPath />
                                    <nav id='links'>
                                        <a href=$signOutLink>Sign Out</a>
                                        <a href=$editProfileLink>Edit Profile</a>
                                        <a id='home' href=$homeLink>Last Stats</a>
                                        <a href=$statsLink>Stats</a>
                                        <a href=$countriesLink>Countries</a>
                                        <a href=$pendingLink>Pending</a>
                                    </nav>
                                </section>
                                $imageClick
                            "
                        );
                else {
                    $isMemberAccepted=$user->isAccepted;
                    $statsAnchorTag=$isMemberAccepted
                        ?"<a href=$statsLink>Stats</a>"
                        :null;
                    return  //If Member
                        "   
                            <section id='navbar'>
                                <img src=$navbarIconPath />
                                <nav id='links'>
                                    <a href=$signOutLink>Sign Out</a>
                                    <a href=$editProfileLink>Edit Profile</a>
                                    <a id='home' href=$homeLink>Last Stats</a>
                                    $statsAnchorTag
                                </nav>
                            </section>
                            $imageClick
                        "
                ;}
            }
            return //If Signed Out
                "
                <section id='navbar'>
                    <img src=$navbarIconPath />
                    <nav id='links'>
                        <a id='home' href=$homeLink>Last Stats</a>
                        <a href=$signInLink>Sign In</a>
                        <a href=$memberSignUpLink>Sign Up</a>

                    </nav>
                </section>
                $imageClick
            ";
        }
        private static function generateStylesheets(array $stylesheetsPaths){
            $styleSheetsToReturn='';
            foreach ($stylesheetsPaths as $stylesheetPath){
                $styleSheetsToReturn.="<link rel='stylesheet' href=$stylesheetPath>";
            }
            return $styleSheetsToReturn;
        }
        public static function generateHead(string $pageTitle, string $favIconPath, array $stylesheetsPaths, array $navbarLinks){
            $styleSheets=self::generateStylesheets($stylesheetsPaths);
            $navbar=self::generateNavBar($favIconPath,$navbarLinks);
            print ("
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='utf-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1'>
                    <title>$pageTitle</title>
                    <link rel='icon' type='image/png' href='$favIconPath'/>
                    $styleSheets
                </head>
                $navbar
            ");
        }
        public static function displayErrorMessage(\Exception $e){
            $messageToDisplay=$e->getMessage();
            print_r("<h1>$messageToDisplay</h1>");
            die();
        }
    }
?>
