<?php namespace Library;
    class MySQLDatabase{
        private static $dbh=null;
        public static function getMySqlDbh(){
            if (!self::$dbh){
                $host=\Library\Configs::$coronastats_db_config['host'];
                $dbname= \Library\Configs::$coronastats_db_config['database'];
                $username= \Library\Configs::$coronastats_db_config['username'];
                $password=\Library\Configs::$coronastats_db_config['password'];
                $dsn="mysql:host=$host;dbname=$dbname";
                self::$dbh=new \PDO($dsn,$username,$password,[]);
            }
            return self::$dbh;
        }
        
    }

?>

<!-- I chose for all my databse classes to be static, there is no need for instantiation -->