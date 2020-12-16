<?php namespace Models;

use Exception;

class User{
    public static function getUsername(int $id){
        if ($id==0)
            throw new Exception('invalid id');
        $dbh=\Library\MySQLDatabase::getMySqlDbh();
        $sqlStatementGetUsername='SELECT username FROM users WHERE id=:id';
        $pdoStatementGetUsername=$dbh->prepare($sqlStatementGetUsername);
        $pdoStatementGetUsername->bindValue('id',$id);
        if (!$pdoStatementGetUsername->execute())
            throw new Exception('something went wrong while getting username');
        if ($pdoStatementGetUsername->rowCount()==0)
            throw new Exception('could not find username');
        $user=$pdoStatementGetUsername->fetch(\PDO::FETCH_OBJ);
        return $user->username;
    }
    public static function approveUser(int $id){
        if ($id==0)
            throw new Exception('invalid user id');
        $dbh=\Library\MySQLDatabase::getMySqlDbh();
        $sqlStatementApproveUser='UPDATE users SET isAccepted=1 WHERE id=:id';
        $pdoStatementApproveUser=$dbh->prepare($sqlStatementApproveUser);
        $pdoStatementApproveUser->bindValue('id',$id,\PDO::PARAM_INT);
        if (!$pdoStatementApproveUser->execute())
            throw new Exception('something went wrong when approving user');
        if ($pdoStatementApproveUser->rowCount()==0)
            throw new Exception('user was not updated');
    }
    public static function rejectUser(int $id){
        if ($id==0)
            throw new Exception('invalid user id');
        $dbh=\Library\MySQLDatabase::getMySqlDbh();
        $sqlStatementRejectUser='DELETE FROM users WHERE id=:id';
        $pdoStatementRejectUser=$dbh->prepare($sqlStatementRejectUser);
        $pdoStatementRejectUser->bindValue('id',$id,\PDO::PARAM_INT);
        if (!$pdoStatementRejectUser->execute())
            throw new Exception('something went wrong when rejecting user');
        if ($pdoStatementRejectUser->rowCount()==0)
            throw new Exception('user was not deleted');
    }
    public static function getPendingUsers(){
        $dbh=\Library\MySQLDatabase::getMySqlDbh();
        $sqlStatementSelectPendingUsers="SELECT email,phoneNumber,id FROM users WHERE isAccepted=0";
        $pdoStatementSelectPendingUsers=$dbh->prepare($sqlStatementSelectPendingUsers);
        if (!$pdoStatementSelectPendingUsers->execute())
            throw new Exception('something went wrong when fetching pending users');
        return $pdoStatementSelectPendingUsers->fetchAll(\PDO::FETCH_OBJ);
    }
        public static function signUpUser(string $username,string $email,string $phoneNumber,string $password){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            if (self::isUserExisting($email))
                throw new Exception("user $email already exists");
            //There exists an isAccepted field, which is by default 0
            $sqlStatementInsertIntoUsers='INSERT INTO users (username,email,phoneNumber,password)
                                            VALUES (:username,:email,:phoneNumber,:password)';
            $pdoStatementInsertIntoUsers=$dbh->prepare($sqlStatementInsertIntoUsers);
            $pdoStatementInsertIntoUsers->bindValue('email',$email,\PDO::PARAM_STR);
            $pdoStatementInsertIntoUsers->bindValue('username',$username,\PDO::PARAM_STR);
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
        public static function updateUser(string $email,string $newPassword,string $username){
            $dbh=\Library\MySQLDatabase::getMySqlDbh();
            $sqlStatementUpdatePassword="UPDATE users SET password=:newPassword,username=:username
                                            WHERE email=:email";
            $pdoStatementUpdatePassword=$dbh->prepare($sqlStatementUpdatePassword);
            $pdoStatementUpdatePassword->bindValue('newPassword',sha1($newPassword),\PDO::PARAM_STR);
            $pdoStatementUpdatePassword->bindValue('email',$email,\PDO::PARAM_STR);
            $pdoStatementUpdatePassword->bindValue('username',$username,\PDO::PARAM_STR);
            if (!$pdoStatementUpdatePassword->execute())
                throw new \Exception('Something Went Wrong While Updating User');
            if ($pdoStatementUpdatePassword->rowCount()==0)
                throw new Exception('user was not updated');
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