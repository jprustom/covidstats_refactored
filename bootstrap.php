<?php session_start(['name'=>'covidstats']) ?>
<?php 
        function importClass($class_name) {
                $class_name=strtolower($class_name);
                if ($class_name==='configs'){
                        require_once ('configs.php');
                        return;
                }
                require_once ('models/' . $class_name . '.php');
        }
                
        spl_autoload_register('importClass');
?>