<?php
    $coronastats_db_config=[
        "host"=>'localhost',
        "database"=>'coronavirus',
        "username"=>'jeanpaulrustom',
        "password"=>'iL0vePr0gramm$ng'
    ];


    function getTitle(){
        global $inside_add_stats;
        global $inside_add_country;
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
    function getPathToRoutes($route_name){
        global $inside_routes;
        if ($inside_routes)
            return("./$route_name.php");
        //inside root index
        return("./routes/$route_name.php");
    }
    function getPathToHome(){
        global $inside_routes;
        if ($inside_routes)
            return('./../index.php');
        //inside root index
        return('');
    }

?>