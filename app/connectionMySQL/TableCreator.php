<?php


namespace App\connectionMySQL;

use App\Config;
use PDO\DB;

class TableCreator
{

    protected object $db;
    const QUEUE = "
        create table if not exists queue(
                    id int PRIMARY KEY auto_increment ,     
                    created_at timestamp DEFAULT CURRENT_TIMESTAMP,                       
                    updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,                    
                    className varchar(100),
                    urlHook varchar(2000),
                    inputData TEXT,
                    attempts TINYINT DEFAULT 0,
                    isWokeds BOOLEAN DEFAULT FALSE NOT NULL
                )
        ";

    public function __construct(){
        $this->db = new DB(Config::HOST, Config::PORT, Config::NAME_DB, Config::USER, Config::PASSWORD);
    }


    public function createAllTables()
    {
        $this->db->pdo->exec(self::QUEUE);

        $this->db->closeConnection();
    }

}