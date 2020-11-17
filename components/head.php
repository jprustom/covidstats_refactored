<!-- A dynamic common script for all my pages, which will handle common tasks such as getting paths to styles/utils folders -->
<?php
        //The bools above will be of use in the config script, which will generate paths to routes folder & home index
        $inside_routes=strpos($_SERVER['REQUEST_URI'], 'routes');
        $inside_utils=strpos($_SERVER['REQUEST_URI'],'utils');
        $inside_home=!$inside_routes&&!$inside_utils;

        
        //I will only need to determine the utils path here, to require configs.php & helpers.php
        //All the other paths are handled by the config class
        $path_to_utils='./utils/';
        if ($inside_routes)
                $path_to_utils='../utils/';
        else if ($inside_utils)
                $path_to_utils='./';
        
        require_once("$path_to_utils".'configs.php');
        require_once("$path_to_utils".'helpers.php');

?>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo Configs::getPageTitle()?></title>
        <meta name="description" content="">
        <link rel="icon" type="image/png" href="<?php echo(Configs::getPathToFavicon()) ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href=<?php echo(Configs::getPathToStyles()."main.css") ?>>
        <link rel="stylesheet" href=<?php echo($inside_home?Configs::getPathToStyles()."index.css":null) ?>>
        <link rel="stylesheet" href=<?php echo(Configs::getPathToStyles()."navbar.css") ?>>
        <link rel="stylesheet" href=<?php echo($inside_add_country?Configs::getPathToStyles().'add_country.css':null) ?>>
        <link rel="stylesheet" href=<?php echo($inside_add_stats?Configs::getPathToStyles().'add.css':null) ?>>
        <link rel="stylesheet" href=<?php echo($inside_details?Configs::getPathToStyles().'details.css':null) ?>>
</head>
