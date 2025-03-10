<?php 

namespace Application\Lib;

use Application\Lib\DatabaseConnection;
use Application\Lib\Tools;
use Application\Lib\Logger;

abstract class Repository
{
    // CONST FOR REPOSITORY WORKING
    const TABLE_NAME = 'undefined';
    const CLASS_NAME = 'undefined';
    const ID_NAME = 'id';
    const ATTRIBUTES_NAME = 'undefined';
    const ATTRIBUTES_PREPARE = 'undefined';

    // CONST FOR LOGGER WORKING
    const LOG_TABLE = 'logs';

    protected DatabaseConnection $database;
    protected Logger $logger;

    public function __construct (DatabaseConnection $database, Logger $logger)
    {
        $this->database = $database;
        $this->logger = $logger;
    }

    protected function dataInClass(array $data)// Return an instance of static::CLASS_NAME with the data in argument
    {
        $class = 'Application\Lib\Classes\\'.static::CLASS_NAME;
        return new $class($data);
    }

    protected function dataInArray(\PDOStatement $statement):array // Put all the data in an array of class
    {
        $data = [];

        while($row = $statement->fetch())
        {
            $data[] = $this->dataInClass($row);
        }

        return $data;
    }

    protected function arrayInString(array $data,?string $delimiter = null):string //Replace all the data in array ($data) into a string seperated by ($delimiter) if you don't give any argument for $delimiter, the delimiter will be ',' 
    {
        $string = '';

        if($delimiter === null) $delimiter = ',';
        
        foreach($data as $row)
        {
            $string = $string.$row.$delimiter;
        }
        
        rtrim($string,',');
        
        return $string;
    }

    protected function verifyNameData(array $data):bool //Verify if the array as the right keys to be insert in a SQL query
    {
        foreach($data as $key => $value)
        {
            if(!strpos(static::ATTRIBUTES_NAME,$key))
            {
                return false;
            }
        }

        return true;
    }

    public function maxId()
    {
        $dataStatement = $this->database->getConnection()->query('SELECT MAX('.static::ID_NAME.') FROM '.static::TABLE_NAME);

        $name = 'Select max id of '.static::TABLE_NAME;
        $log = 'Selecting the next free id in the '.static::TABLE_NAME.' table';
        $action = 'SELECT';

        return $dataStatement->fetch()[0];
    }

    public function howMany()
    {
        $dataStatement = $this->database->getConnection()->query('SELECT COUNT(*) FROM '.static::TABLE_NAME);

        $name = 'Select count of '.static::TABLE_NAME;
        $log = 'Selecting the number of row in the '.static::TABLE_NAME.' table';
        $action = 'SELECT';

        $this->newLog($name,$log,$action);

        return $dataStatement->fetch()[0];
    }

    protected function getData():array // Get all the data of a table and return it in an array maked by the method dataInArray();
    {
        $dataStatement = $this->database->getConnection()->query('SELECT * FROM '.static::TABLE_NAME);
        
        return $this->dataInArray($dataStatement);
    }

    protected function getDataById(int $id) // Get an element with his id and return an instance of static::CLASS_NAME
    {
        $dataStatement = $this->database->getConnection()->query('SELECT * FROM '.static::TABLE_NAME.' WHERE '.static::ID_NAME.' = '.$id);

        $data = $dataStatement->fetch();

        if(empty($data)) {
            return false;
        }

        return $this->dataInClass($data);
    }

    protected function insertData(array $data):int|bool
    {
        // $insertStatement = $this->database->getConnection()->prepare('INSERT INTO '.static::TABLE_NAME.'('.str_replace(static::ID_NAME.',','',static::ATTRIBUTES_NAME).') VALUES('.static::ATTRIBUTES_PREPARE.')');
        try {
            $tableBis = str_replace(static::ID_NAME.',','',str_replace('is_admin','',static::ATTRIBUTES_NAME));
            $table = rtrim($tableBis,',');
    
            $valuesBis = str_replace(',',',:',str_replace(static::ID_NAME.',','',str_replace('is_admin','',static::ATTRIBUTES_NAME)));
            $values = rtrim($valuesBis,',:');
    
            $query = 'INSERT INTO '.static::TABLE_NAME.'('.$table.') VALUES(:'.$values.')';
    
            // Tools::debugVar($table);
            // Tools::debugVar($values);
            // Tools::debugVar($data);
            // Tools::debugVar($query);
    
            $insertStatement = $this->database->getConnection()->prepare($query);
            $insertStatement->execute($data);
            $id = $this->lastId();
            
            return $id;
        }
        catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
    }

    // protected function patchData(int $id,array $data):bool
    // {
    //     //A modifier avec le system PATCH
    //     $attributes = explode(',',static::ATTRIBBUTES_NAME);
    //     $queryAttributes = $this->arrayInString($attributes,' = ?,');
    //     $data[] = $id;

    //     $updateStatement = $this->database->getConnection()->prepare('UPDATE '.static::TABLE_NAME.' SET '.$queryAttributes.' WHERE '.static::ID_NAME.' = '.$id);
    //     $updateStatement->execute($data);

    //     return true;
    // }

    protected function updateData(int $id,array $data):bool
    {
        
        if(!$this->verifyNameData($data))
        {
            throw new \RuntimeException('Nom de donnée inexistante');
        }
        $keys = \array_keys($data);
        $keysInString = $this->arrayInString($keys,' = ?,');

        $updateStatement = $this->database->getConnection()->prepare('UPDATE '.static::TABLE_NAME.' SET '.$keysInString.' WHERE '.static::ID_NAME.' = '.$id);
        $updateStatement->execute($data);

        return true;
    }

    protected function deleteData(int $id):bool
    {
        $deleteStatement = $this->database->getConnection()->prepare('DELETE FROM '.static::TABLE_NAME.' WHERE '.static::ID_NAME.' = ?');
        $deleteStatement->execute([$id]);

        return true;
    }

    protected function deleteMultipleData(array $data):bool
    {
        $dataInString = $this->arrayInString($data);
        $deleteStatement = $this->database->getConnection()->query('DELETE FROM '.static::TABLE_NAME.' WHERE '.static::ID_NAME.' IN ('.$dataInString.')');
        $deleteStatement->fetch();

        return true;
    }

    protected function lastId():string
    {
        return $this->database->getConnection()->lastInsertId();
    }

    protected function newLog(string $name,string $log,string $action):bool
    {
        // try {
        //     return $this->logger->registerLog($name,$log,static::TABLE_NAME,$action);
        // }
        // catch(\Exception $e) {
        //     throw new \Exception('Erreur :'.$e->getMessage());
        // }
        return true;
    }
}