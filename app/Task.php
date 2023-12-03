<?php

namespace App;

class Task
{
    protected string $className;
    protected string $urlHook;
    protected string $inputData;
    protected bool $validTask;

    protected string $workersMethod;
    protected bool $result;
    public function __construct(array $data){
        $this->validTask = false;
        if (!empty($data)){
            $this->className = $data['className'];
            $this->urlHook = $data['urlHook'];
            $this->inputData = $data['inputData'];
            $this->checkValid();
            $this->setWorkersMethod();
            $this->result=false;
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

    public function setResult(bool $result): void
    {
        $this->result = $result;
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



}