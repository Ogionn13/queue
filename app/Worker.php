<?php

namespace App;

class Worker
{
    protected Task $task;
    private bool $result;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->run();
    }

    private function run()
    {
        $method = $this->task->getWorkersMethod();
        $this->$method();
        $this->task->setResult();

    }

    private function runScript(){
        $className = $this->task->getClassName();
         $class = new $className($this->task->getInputData());
         $this->result = $class->getResult();
    }

    private function sentToScript(){
        $url = $this->task->getUrlHook();

    }

}