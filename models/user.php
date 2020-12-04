<?php namespace Models;
    class User{
        public static function updateUserPassword($email,$newPassword){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdatePassword="UPDATE users SET password=':newPassword'
                                            WHERE email=':email' ";
            $pdoStatementUpdatePassword=$dbh->prepare($sqlStatementUpdatePassword);
            $pdoStatementUpdatePassword->bindValue('newPassword',sha1($newPassword),\PDO::PARAM_STR);
            $pdoStatementUpdatePassword->bindValue('email',$email,\PDO::PARAM_STR);
            if (!$pdoStatementUpdatePassword->execute())
                throw new \Exception('Something Went Wrong While Updating User');
            
        }
        public static function loginUser($email,$password){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $password=sha1($password);
            $sqlStatementSelectUser="SELECT * FROM users WHERE email=:email
                                        AND password=:password";
            $pdoStatementSelectUser=$dbh->prepare($sqlStatementSelectUser);
            $pdoStatementSelectUser->bindValue('email',$email,\PDO::PARAM_STR);
            $pdoStatementSelectUser->bindValue('password',$password,\PDO::PARAM_STR);
            if($pdoStatementSelectUser->execute()){
                $user_returned=$pdoStatementSelectUser->fetch(\PDO::FETCH_OBJ);
                return $user_returned;
            }
            throw new \Exception('Credentials are not valid');
        }
        private static function checkIfUserExists($email){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectUser="SELECT * FROM users WHERE email=:email";
            $pdoStatementSelectUser=$dbh->prepare($sqlStatementSelectUser);
            $pdoStatementSelectUser->bindValue('email',$email,\PDO::PARAM_STR);
            if($pdoStatementSelectUser->execute()){
                $user_returned=$pdoStatementSelectUser->fetch(\PDO::FETCH_OBJ);
                return $user_returned;
            }
            throw new \Exception('An error occured while trying to fetch user');
        }
    //     public static function createUser($email,$password){
    //         $dbh=\Library\MySQLDatabase::getMySqlDbh();
    //         if (self::checkIfUserExists($email))
    //             throw new \Exception("User with email $email already exists.");
            
    //         $sqlStatementInsertIntoUsers='INSERT INTO users (email,password)
    //                                         VALUES (:email,:password)';
    //         $pdoStatementInsertIntoUsers=$dbh->prepare($sqlStatementInsertIntoUsers);
    //         $pdoStatementInsertIntoUsers->bindValue('email',$email,\PDO::PARAM_STR);
    //         $pdoStatementInsertIntoUsers->bindValue('password',sha1($password),\PDO::PARAM_STR);
    //         if(!$pdoStatementInsertIntoUsers->execute()){; //returns false if execution fails, error is also printed
    //             throw new \Exception('Something went wrong when creating account');
    //     }
    // }
}

?>