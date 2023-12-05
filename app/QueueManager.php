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
        $this->getLastTimeStart()->checkFinishLastScript();

    }

    protected function getLastTimeStart(): QueueManager
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
        unlink(Config::LAST_TIME_START_FILE);
    }

    public function isCanStart():bool{
        return $this->canStart;
    }

    protected function isHaveNextTask():bool{
        $this -> nextTask = $this->queue->getTask();
        return $this->nextTask->isValidTask();
    }

    protected function createFileStartTime(){
        file_put_contents(Config::LAST_TIME_START_FILE, $this->timestampStart);
    }

    protected function isHaveTimeForTask():bool{
        if (time() - $this->timestampStart <= Config::TIME_OF_WORK){
            return true;
        }
        return false;
    }

    public function start(){
        $this->createFileStartTime();
        while ($this->isHaveTimeForTask() and $this->isHaveNextTask()){
            $this->queue->registerStartWork($this -> nextTask);
            new Worker($this->nextTask);
            $this->queue->registerFinishWork($this -> nextTask);

        }
    }

}