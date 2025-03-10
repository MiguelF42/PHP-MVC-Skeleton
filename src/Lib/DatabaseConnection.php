<?php

namespace Application\Lib;

class DatabaseConnection {

    public ?\PDO $database=null;

    public function getConnection():\PDO {

        $host = 'localhost';
        $db = 'db';
        $login = 'root';
        $password = 'root';

        if($this->database === null){
            $this->database = new \PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8',$login,$password);
        }
        return $this->database;

    }

}