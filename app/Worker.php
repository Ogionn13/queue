<?php

namespace App;

class Worker
{
    protected Task $task;




    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->run();
    }

    private function run()
    {
        $method = $this->task->getWorkersMethod();
        $result  = $this->$method();
        $this->task->setResult($result);

    }

    private function runScript(){
        $className = $this->task->getClassName();
         $class = new $className($this->task->getInputData());
         $this->result = $class->getResult();
    }

    private function sentToScript(){
        $url = $this->task->getUrlHook();
        $data = $this->task->getInputData();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_decode($data,true));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code;
    }

}