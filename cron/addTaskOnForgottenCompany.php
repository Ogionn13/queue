<?php

use App\connectionMySQL\AutoTask;
use App\connectionMySQL\Queue;


    const ROOT = __DIR__."/..";
    require_once ROOT . "/vendor/autoload.php";

    $autoTask = new AutoTask();
    $queue = new Queue();

    $companies = $autoTask->getCompanies();

    foreach ($companies as $company){
        $dto  = [
            "hook" => "addTaskOnForgottenCompany",
            "inputData" => json_encode($company)
        ];
        $queue->insertOneInTable($dto);
    }

