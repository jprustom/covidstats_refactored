<?php
    $inside_add_country=strpos($_SERVER['REQUEST_URI'], 'add_country.php');
    $inside_add_stats=strpos($_SERVER['REQUEST_URI'], 'add.php');
    $inside_details=strpos($_SERVER['REQUEST_URI'],'details.php');
    require_once("$path_to_utils".'database.php');
    class Configs{

        public static function getPathToFavicon(){
            global $inside_routes;
            global $inside_utils;
            if ($inside_routes || $inside_utils)
                return '../images/icon.png';
            return './utils/';
        }
        public static function getPathToStyles(){
            global $inside_routes;
            global $inside_utils;
            if ($inside_routes || $inside_utils)
                return '../styles/';
            return './styles/';
        }
        public static $coronastats_db_config=[
            "host"=>'localhost',
            "database"=>'coronavirus',
            "username"=>'jeanpaulrustom',
            "password"=>'iL0vePr0gramm$ng'
        ];
        public static function getPageTitle(){
            global $inside_add_country;
            global $inside_add_stats;
            global $inside_details;
            if ($inside_add_country)
                return 'Add Country';
            if ($inside_add_stats){
                return 'Add new stats';
            }
            if($inside_details){
                $countryName=ucwords($_GET['countryName']);
                return "Details for $countryName";
            }
            //In home page
            return 'Corona Last Stats';
            
        }
        public static function getPathToRoutes($route_name){
            global $inside_routes;
            global $inside_utils;
            if ($inside_routes)
                return("./$route_name.php");
            if ($inside_utils)
                return("../routes/$route_name.php");
            //inside root index
            return("./routes/$route_name.php");
        }
        public static function getPathToHome(){
            global $inside_routes;
            global $inside_utils;
            if ($inside_routes || $inside_utils)
                return('../index.php');
            //inside root index
            return('');
        }
    }
    $mysql_instance=new MySQLDatabase(
        Configs::$coronastats_db_config['host'],
        Configs::$coronastats_db_config['database'],
        Configs::$coronastats_db_config['username'],
        Configs::$coronastats_db_config['password']);
?>