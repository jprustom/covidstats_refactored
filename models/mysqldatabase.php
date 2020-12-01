<!-- I chose for all my databse classes to be static, there is no need for instantiation -->
<?php
    class MySQLDatabase{
        private static $dbh=null;
        public static function getMySqlDbh(){
            if (!self::$dbh){
                $host=Configs::$coronastats_db_config['host'];
                $dbname= Configs::$coronastats_db_config['database'];
                $username= Configs::$coronastats_db_config['username'];
                $password=Configs::$coronastats_db_config['password'];
                $dsn="mysql:host=$host;dbname=$dbname";
                self::$dbh=new PDO($dsn,$username,$password,[]);
            }
            return self::$dbh;
        }
        
    }

?>