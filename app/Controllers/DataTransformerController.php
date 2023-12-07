<?php

namespace App\Controllers;

use App\Task;
use PTS\DataTransformer\DataTransformer;

class DataTransformerController
{
    private DataTransformer $dataTransformer;

    public function __construct()
    {
        $this->dataTransformer = new DataTransformer;
        $this->dataTransformer->getMapsManager()->setDefaultMapDir(ROOT . '/modules/ModelRules/');
    }

    public function TaskMapper($data): Task
    {
        return $this->dataTransformer->toModel(Task::class, $data, 'deepDto');
    }

}