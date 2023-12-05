<?php

namespace App;

class Task
{
    protected string $className;
    protected string $urlHook;
    protected string $inputData;
    protected bool $validTask;


    protected int $timestampTake;
    protected int $timestampWait;
    protected int $timeStampLenWork;

    protected string $workersMethod;
    protected bool $result;

    protected int $attempts;

    protected int $id;
    public function __construct(?array $data){

        $this->validTask = false;
        if (!empty($data)){
            $this->id = empty($data['id'])?"":$data['id'];
            $this->className = empty($data['className'])?"":$data['className'];
            $this->urlHook = empty($data['urlHook'])?"":$data['urlHook'];
            $this->inputData = empty($data['inputData'])?"":$data['inputData'];
            $this->attempts = $data['attempts']+1;
            $this->checkValid();
            $this->setWorkersMethod();
            $this->result=false;
            $this->timestampTake = time();
            $this->timestampWait =$this->timestampTake - strtotime($data['created_at']);


        }

    }

    /**
     * @return int
     */
    public function getAttempts(): int
    {
        return $this->attempts;
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return int
     */
    public function getTimestampWait(): int
    {
        return $this->timestampWait;
    }

    public function calcTimestampLenWork(){
        $this->timeStampLenWork = time() - $this->timestampTake;
    }

    /**
     * @return int
     */
    public function getTimeStampLenWork(): int
    {
        return $this->timeStampLenWork;
    }

    public function setResult(bool $result){
        $this->result = $result;
    }

}