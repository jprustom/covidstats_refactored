<?php session_start(['name'=>'covidstats']) ?>
<?php
        //1-Check for session validity
        $isLoggedIn=isset($_SESSION['user']);
        if ($isLoggedIn){
                $isMember=$_SESSION['user']['isAdmin']==false;
                if (!$isMember && isset($_SESSION['lastActivityTimeStamp'])){
                        $lastActivityTimeStamp=$SESSION['lastActivityTimeStamp'];
                        if (time()-$lastActivityTimeStamp>15*60*1000)
                                $_SESSION['user']=null;
                }
                //2-Update session timestamp
                $_SESSION['lastActivityTimeStamp']=time();
        }
?>
<?php 
        function importClass($class_name) {
                $class_name=strtolower($class_name);
                $class_name=str_replace('\\','/',$class_name);
                require_once("$class_name.php");
        }
                
        spl_autoload_register('importClass');
?>