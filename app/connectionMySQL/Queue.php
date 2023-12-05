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

        $data = $this->select("WHERE `isWorked` = 0 and `attempts` < ". Config::MAX_ATTEMPTS . " ORDER BY `attempts` LIMIT 1");

        $this->lastTask = new Task($data[0]);
        return $this->lastTask;
    }




    public function registerFinishWork(Task $task){
        $params = $this->changeBoolToInt([
            "isWorked" => $task->isResult(),
            "timeWorking" => $task->getTimeStampLenWork()
        ]);
        $this->updateById($task->getId(),$params);

    }

    public function registerStartWork(Task $task){
        $params = $this->changeBoolToInt([
            "attempts" => $task->getAttempts(),
            "timeWaiting" => $task->getTimestampWait()
        ]);
        $this->updateById($task->getId(), $params);

    }




}