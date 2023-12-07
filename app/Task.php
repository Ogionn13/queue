<?php

namespace App;

class Task
{
    protected string $className;
    protected string $urlHook;
    protected string $inputData;
    protected int $timestampWait;
    protected int $timestampLenWork;
    protected int $timestampTake;

    protected bool $result;

    protected int $attempts;

    protected int $id;


    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function isValidTask(): bool
    {
        if (!empty($this->className) or !empty($this->urlHook)) {
            return true;
        }
        return false;
    }

    public function getWorkersMethod(): string
    {
        if (!empty($this->className)) {
            return "runScript";
        } else {
            return "sentToScript";
        }
    }

    public function getInputData(): string
    {
        return $this->inputData;
    }

    public function isResult(): bool
    {
        return $this->result;
    }

    public function setResult(bool $result)
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

    public function calcTimestampLenWork()
    {
        $this->timestampLenWork = time() - $this->timestampTake;
    }

    public function getTimeStampLenWork(): int
    {
        return $this->timestampLenWork;
    }

    public function setTimestampTake(): void
    {
        $this->timestampTake = time();
    }

}