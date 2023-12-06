<?php

namespace App\connectionMySQL;

use App\Config;
use App\Controllers\DataTransformerController;
use App\Task;


class QueueTable extends DataBaseManager
{
    protected Task  $lastTask;

    public function isUniqueInputData(string $inputData):bool
    {
        $data = $this->select( "WHERE `inputData` = '$inputData' and `isWorked` = 0 and `attempts` < ".Config::MAX_ATTEMPTS);
        if (empty($data))
            return true;
        return false;
    }


    protected function setTableName(): void
    {
        $this->table = Config::TABLE_QUEUE;

    }

    public function getTask(): Task
    {
        $data = $this->select("WHERE `isWorked` = 0 and `attempts` < ". Config::MAX_ATTEMPTS . " ORDER BY `attempts` LIMIT 1");
        $data = (empty($data))? []: $data[0];
        $task = $this->dataTransformerController->TaskMapper($data);
        $task->setTimestampTake();
        return $task;
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