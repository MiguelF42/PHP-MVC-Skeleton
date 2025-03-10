<?php

namespace Application\Lib;

use Application\Lib\Classes\User;
use Application\Model\UserRepository;

class Tools {

    public static int $counter = 0;
    public static int $timer = 1;
    private static ?UserRepository $userRepository = null;

    private static function getUserRepo()
    {
        if(self::$userRepository === null) {
            $db = new DatabaseConnection();
            $logger = new Logger($db);
            self::$userRepository = new UserRepository($db, $logger);
        }
        return self::$userRepository;
    }

    public static function debugVar($var) 
    {
        echo '<pre>';
        \var_dump($var);
        echo '</pre>';
    }

    public static function sqlDump($var) 
    {
        while($row = $var->fetch()) 
        {
            self::debugVar($row);
            echo '--------------------------------------------------------------';
        }
    }

    public static function printLog()
    {
        echo 'test n°'.self::$counter.'</br>';
        self::$counter += 1;
    }

    public static function redirect(string $link) 
    {
        \header('refresh:'.self::$timer.';url='.$link);
        exit;
    }

    public static function isAPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') return $_POST;
        else return null;
    }

    public static function verifyDateInput(string $date):bool
    {
        $dateInArray = explode('-',$date);
        return checkdate($dateInArray[1],$dateInArray[2],$dateInArray[0]); 
    }

    public static function getSession():User
    {
        return unserialize($_SESSION['user']);
    }

    public static function defaultUser():void
    {
        if(isset($_SESSION['token'])) $token = $_SESSION['token'];

        session_destroy();
        session_start();

        $data = [
            'user_id' => 1,
            'firstname' => 'default',
            'lastname' => 'default',
            'email' => 'default@default.com',
            'speciality' => 'default',
            'is_admin' => 0
        ];
        
        $_SESSION['user'] = serialize(new User($data));
        if(isset($token)) $_SESSION['token'] = $token;
    }

    public static function getSessionUserId():int
    {
        return unserialize($_SESSION['user'])->getUserId();
    }

    public static function verifyUser():bool {
        $userToVerify = self::getSession();
        if($userToVerify->getUserId() === 1) return false;
        
        $userRepository = self::getUserRepo();
        $user = $userRepository->getUserById($userToVerify->getUserId());

        if($user == $userToVerify) return true;
        else return false;
    }

    public static function userIsAdmin():bool
    {
        $userRepository = self::getUserRepo();

        $id = self::getSessionUserId();

        try {
            $user = $userRepository->getUserById($id);
            if(!$user->getIsAdmin()) return false;
            else return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public static function genPasswd(int $length = 12):string {
        $charlist = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789(){}[]#&+=_-|%!?;,.:/\\*";

        $passwd = '';

        for($i = 0;$i < $length;$i ++) {
            $val = rand(0,strlen($charlist)-1);
            $passwd = $passwd . $charlist[$val];
        }

        return $passwd;
    }
}