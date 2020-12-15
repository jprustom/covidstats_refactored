<?php namespace Models;

use Exception;

class User{
        public static function signUpUser(string $email,string $phoneNumber,string $password){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            if (self::isUserExisting($email))
                throw new Exception("user $email already exists");
            //There exists an isAccepted field, which is by default 0
            $sqlStatementInsertIntoUsers='INSERT INTO users (email,phoneNumber,password)
                                            VALUES (:email,:phoneNumber,:password)';
            $pdoStatementInsertIntoUsers=$dbh->prepare($sqlStatementInsertIntoUsers);
            $pdoStatementInsertIntoUsers->bindValue('email',$email,\PDO::PARAM_STR);
            $pdoStatementInsertIntoUsers->bindValue('phoneNumber',$phoneNumber,\PDO::PARAM_STR);
            $pdoStatementInsertIntoUsers->bindValue('password',sha1($password),\PDO::PARAM_STR);
            if(!$pdoStatementInsertIntoUsers->execute())
                throw new \Exception('Something went wrong when adding new user');
            if($pdoStatementInsertIntoUsers->rowCount()==0)
                throw new Exception('something went wrong, user was not created');
        }
        private static function isUserExisting(string $email){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementSelectUser="SELECT * FROM users WHERE email=:email";
            $pdoStatementSelectUser=$dbh->prepare($sqlStatementSelectUser);
            $pdoStatementSelectUser->bindValue('email',$email,\PDO::PARAM_STR);
            if($pdoStatementSelectUser->execute()){
                if($pdoStatementSelectUser->rowCount()==0)
                    return false;
                return true;
            }
            throw new Exception('something wrong happened while checking if user exists');
        }
        public static function updateUserPassword(string $email,string $newPassword){
    
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdatePassword="UPDATE users SET password=:newPassword
                                            WHERE email=:email";
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
                if($pdoStatementSelectUser->rowCount()==0)
                    throw new \Exception('Something went wrong, user was not updated');
                return $user_returned;
            }
            throw new \Exception('Could not update user');
        }
}

?>