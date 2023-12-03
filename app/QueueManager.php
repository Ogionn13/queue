<?php

namespace App;

use App\connectionMySQL\Queue;

class QueueManager
{
    protected int $timestampStart;
    protected bool $canStart;
    protected int $lastTimestampStart;

    protected Task $nextTask;
    protected Queue $queue;

    public function __construct(Queue $queue){
        $this->timestampStart = time();
        $this->queue = $queue;
        $this->leadLastTime()->checkFinishLastScript();
    }

    protected function leadLastTime(): QueueManager
    {
        $this->lastTimestampStart = 0;
        if (file_exists(Config::LAST_TIME_START_FILE)){
            $this->lastTimestampStart = (int)(file_get_contents(Config::LAST_TIME_START_FILE));
        }
        return $this;
    }

    /**подразумевает что если очередь была запущена более 330 сек назад и по каким то причинам файл с временем запуска не удалился - скрипт остановил сервер
     * @return void
     */
    protected function checkFinishLastScript(){
        if ($this->timestampStart - $this->lastTimestampStart > 330){
            $this->canStart = true;
        } else {
            $this->canStart = false;
        }
    }

    public function finish(){

    }

    public function isCanStart():bool{
        return $this->canStart;
    }

    protected function isHaveNextTask():bool{
        $this -> nextTask = $this->queue->getOneRow();
        return $this->nextTask->isValidTask();
    }

    protected function createFileStartTime(){

    }

    protected function isHaveTimeForTask():bool{
        if (time() - $this->timestampStart <= Config::TIME_OF_WORK)
            return true;
        return false;
    }

    public function start(){
        $this->createFileStartTime();
        while ($this->isHaveTimeForTask() and $this->isHaveNextTask()){
            $worker = new Worker($this->nextTask);
        }
    }

}