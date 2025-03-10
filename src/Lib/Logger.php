<?php

namespace Application\Lib;

use Application\Lib\DatabaseConnection;

class Logger {

    private DatabaseConnection $database;

    public function __construct(DatabaseConnection $database)
    {
        $this->database = $database;
    }

    public function registerLog(string $name,string $log,string $category,string $action):bool
    {
        $logStatement = $this->database->getConnection()->prepare('INSERT INTO `logs`(name,log,category,action,ip,id_user) VALUES(?,?,?,?,?,?)');
        $logStatement->execute([
            $name,
            $log,
            $category,
            $action,
            $_SERVER['REMOTE_ADDR'],
            1
        ]);
        return true;
    }

}