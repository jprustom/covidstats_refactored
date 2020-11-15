<?php
        $inside_routes=strpos($_SERVER['REQUEST_URI'], 'routes');
        $inside_add_country=strpos($_SERVER['REQUEST_URI'], 'add_country.php');
        $inside_add_stats=strpos($_SERVER['REQUEST_URI'], 'add_stats.php');
        $inside_details=strpos($_SERVER['REQUEST_URI'],'details.php');
        $inside_utils=strpos($_SERVER['REQUEST_URI'],'utils');
        $inside_home=!$inside_routes&&!$inside_utils;

        $path_to_styles='./styles/';
        $path_to_utils='./utils/';
        if ($inside_routes){
                $path_to_utils='../utils/';
                $path_to_styles='../styles/';
        }
        else if ($inside_utils){
                $path_to_utils='./';
                $path_to_styles='../styles/';
        }
        require_once("$path_to_utils".'configs.php');
        require_once("$path_to_utils".'database.php');
        require_once("$path_to_utils".'helpers.php');

        
?>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo getTitle()?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href=<?php echo($path_to_styles."main.css") ?>>
        <link rel="stylesheet" href=<?php echo($inside_home?$path_to_styles."index.css":null) ?>>
        <link rel="stylesheet" href=<?php echo($path_to_styles."navbar.css") ?>>
        <link rel="stylesheet" href=<?php echo($inside_add_country?$path_to_styles.'add_country.css':null) ?>>
        <link rel="stylesheet" href=<?php echo($inside_add_stats?$path_to_styles.'add_stats.css':null) ?>>
        <link rel="stylesheet" href=<?php echo($inside_details?$path_to_styles.'details.css':null) ?>>
</head>
