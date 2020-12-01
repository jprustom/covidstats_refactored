<?php 
    class Configs{
        public static $coronastats_db_config=[
            "host"=>'localhost',
            "database"=>'coronavirus',
            "username"=>'root',
            "password"=>''
        ];
        private static function generateNavBar(string $navbarIconPath,array $navbarLinks){
            $homeLink=$navbarLinks['homeLink'];
            $addStatsLink=$navbarLinks['addStatsLink'];
            $addCountryLink=$navbarLinks['addCountryLink'];
            return(
                "
                    <section id='navbar'>
                        <img src=$navbarIconPath />
                        <nav id='links'>
                            <a id='home' href=$homeLink>Last Stats</a>
                            <a href=$addStatsLink>Add Stats</a>
                            <a href=$addCountryLink>Add Country</a>
                        </nav>
                    </section>
                "
            );
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
                    <link rel='icon' type='image/png' href=$favIconPath/>
                    $styleSheets
                </head>
                $navbar
            ");
        }
    }
?>

<?php

    // $inside_add_country=strpos($_SERVER['REQUEST_URI'], 'add_country.php');
    // $inside_add_stats=strpos($_SERVER['REQUEST_URI'], 'add.php');
    // $inside_details=strpos($_SERVER['REQUEST_URI'],'details.php');
    // require_once("$path_to_controllers".'../models/database.php');

    // class Configs{
    //     public static function getPathToFavicon(){
    //         global $inside_routes;
    //         global $inside_controllers;
    //         if ($inside_routes || $inside_controllers)
    //             return '../images/icon.png';
    //         return './images/icon.png';
    //     }
    //     public static function getPathToStyles(){
    //         global $inside_routes;
    //         global $inside_controllers;
    //         if ($inside_routes || $inside_controllers)
    //             return '../styles/';
    //         return './styles/';
    //     }

    //     public static function getPageTitle(){
    //         global $inside_add_country;
    //         global $inside_add_stats;
    //         global $inside_details;
    //         if ($inside_add_country)
    //             return 'Add Country';
    //         if ($inside_add_stats){
    //             return 'Add new stats';
    //         }
    //         if($inside_details){
    //             $countryName=ucwords($_GET['countryName']);
    //             return "Details for $countryName";
    //         }
    //         //In home page
    //         return 'Corona Last Stats';
            
    //     }
    //     public static function getPathToRoutes($route_name){
    //         global $inside_routes;
    //         global $inside_controllers;
    //         if ($inside_routes)
    //             return("./$route_name.php");
    //         if ($inside_controllers)
    //             return("../$route_name.php");
    //         //inside root index
    //         return("./$route_name.php");
    //     }
    //     public static function getPathToHome(){
    //         // global $inside_routes;
    //         // global $inside_controllers;
    //         // if ($inside_routes || $inside_controllers)
    //         //     return('../index.php');
    //         //inside root index
    //         return('index.php');
    //     }
    // }

?>