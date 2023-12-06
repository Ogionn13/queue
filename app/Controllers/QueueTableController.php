<?php

namespace App\Controllers;

use App\Config;
use App\connectionMySQL\QueueTable;
use App\Task;
use App\Worker;

class QueueTableController
{
    protected int $timestampStart;
    protected bool $canStart;
    protected int $lastTimestampStart;

    protected Task $nextTask;
    protected QueueTable $queueTable;

    public function __construct(QueueTable $queue){
        $this->timestampStart = time();
        $this->queueTable = $queue;
        $this->getLastTimeStart()->checkFinishLastScript();

    }

    public function start(){
        $this->createFileStartTime();
        while ($this->isHaveTimeForTask() and $this->isHaveNextTask()){
            $this->queueTable->registerStartWork($this -> nextTask);
            new Worker($this->nextTask);
            $this->queueTable->registerFinishWork($this -> nextTask);

        }
    }

    /**Подразумевает что если очередь была запущена более 330 сек назад и по каким то причинам файл с временем запуска не удалился - скрипт остановил сервер
     * @return void
     */
    protected function checkFinishLastScript(){
        if ($this->timestampStart - $this->lastTimestampStart > 330){
            $this->canStart = true;
        } else {
            $this->canStart = false;
        }
    }

    protected function getLastTimeStart(): QueueTableController
    {
        $this->lastTimestampStart = 0;
        if (file_exists(Config::LAST_TIME_START_FILE)){
            $this->lastTimestampStart = (int)(file_get_contents(Config::LAST_TIME_START_FILE));
        }
        return $this;
    }

    public function isCanStart():bool{
        return $this->canStart;
    }


    protected function isHaveNextTask():bool{
        $this -> nextTask = $this->queueTable->getTask();
        return $this->nextTask->isValidTask();
    }
    protected function isHaveTimeForTask():bool{
        if (time() - $this->timestampStart <= Config::TIME_OF_WORK){
            return true;
        }
        return false;
    }

    protected function createFileStartTime(){
        file_put_contents(Config::LAST_TIME_START_FILE, $this->timestampStart);
    }

    public function finish(){
        unlink(Config::LAST_TIME_START_FILE);
    }

}