<?php

namespace App;

class Task
{
    protected string $className;
    protected string $urlHook;
    protected string $inputData;
    protected bool $validTask;

    protected int $timeStampCreate;

    protected string $workersMethod;
    protected bool $result;
    public function __construct(array $data){
        var_dump($data);
        $this->validTask = false;
        if (!empty($data)){
            $this->timeStampCreate = strtotime($data['created_at']);
            $this->className = empty($data['className'])?"":$data['className'];
            $this->urlHook = empty($data['urlHook'])?"":$data['urlHook'];
            $this->inputData = empty($data['inputData'])?"":$data['inputData'];
            $this->checkValid();
            $this->setWorkersMethod();
            $this->result=false;
//var_dump($this);
        }

    }
    private function setWorkersMethod()
    {
        if (!empty($this->className)){
            $this->workersMethod = "runScript";
        } else{
            $this->workersMethod = "sentToScript";
        }

    }

    private function checkValid()
    {
        if (!empty($this->className) or !empty($this->urlHook))
            $this->validTask = true;
    }


    public function isValidTask(): bool
    {
        return $this->validTask;
    }

    public function getWorkersMethod(){
        return $this->workersMethod;
    }

    public function getInputData(){
        return $this->inputData;
    }

    public function isResult(): bool
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getUrlHook(): string
    {
        return $this->urlHook;
    }

    public function setResult($code){
        if ($code >=200 and $code<=204){
            $this->result = true;
        } else {
            $this->result=false;}
    }



}