<?php

namespace Application\Model;

use Application\Lib\Tools;
use Application\Lib\Repository;
use Application\Lib\Classes\Log;


class LogRepository extends Repository {

    const TABLE_NAME = 'log';
    const CLASS_NAME = 'Log';
    const FIELDS_NAME = [];

    public function getLogs():array|bool
    {
        try {
            return $this->getData();
        }
        catch (\Exception $e){
            echo 'Erreur :'.$e->getMessage();
            return false;
        }
    }

    public function getLogsById(int $logId):Log|bool
    {
        try {
            return $this->getDataById($logId);
        }
        catch(\Exception $e){
            echo 'Erreur :'.$e->getMessage();
            return false;
        }
    }

    public function getLogsByUserId(int $userId):array
    {
        $logStatement = $this->database->getConnection()->query('SELECT * FROM '.self::TABLE_NAME.' WHERE user_id = '.$userId);

        $data = [];

        while($row = $logStatement->fetch())
        {
            $log = new Log($row);
            $data[] = $log;
        }

        return $data;
    }

    // public function registerLog(array $input):bool
    // {
    //     try {
    //         $newLogStatement = $this->database->getConnection()->prepare('INSERT INTO '.self::TABLE_NAME.' (user_id, content) VALUES (:user_id, :content)');
    //         $newLogStatement->execute([
    //             'user_id' => $input['user_id'],
    //             'content' => $input['content']
    //         ]);
    //         return true;
    //     }
    //     catch(\Exception $e) {
    //         return 'Erreur :'.$e->getMessage();
    //     }
    // }
}