<?php

namespace App\connectionMySQL;

use App\Config;
use App\Task;



class Queue extends DataBaseManager
{
    protected Task  $lastTask;


    protected function setTableName(): void
    {
        $this->table = Config::TABLE_QUEUE;

    }

    public function getTask(): Task
    {
        $data = $this->select("WHERE `isWokeds` = 0 ORDER BY `attempts` LIMIT 1");

        $this->lastTask = new Task($data[0]);
        return $this->lastTask;
    }


    protected function registerStartWork(){
        $valueAttempt = $this->lastRow['attempts'];
        $id = $this->lastRow['id'];
        if (is_int($valueAttempt) and is_int($id)){
            $this->updateById($id, ["attempts" => ++$valueAttempt]);
        }
    }


    protected function registerFinishWork(){

    }




}