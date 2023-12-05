<?php

use App\connectionMySQL\AutoTask;
use App\connectionMySQL\Queue;


    const ROOT = __DIR__."/..";
    require_once ROOT . "/vendor/autoload.php";

   // $autoTask = new AutoTask();
    $queue = new Queue();

//    $companies = $autoTask->getCompanies();
    $companies = [
        [
            "last_task_with_result"=>1697186169,
            "company_id"=>33825639
        ],
        [
            "last_task_with_result"=>1697116169,
            "company_id"=>33825640
        ],
        [
            "last_task_with_result"=>1699186169,
            "company_id"=>33825641
        ],
    ];

    foreach ($companies as $company){
        $dto  = [
            "urlHook" => "https://hub3.integr3at.pro/api/trendAgent/queue/dev/test_hook.php",
            "inputData" => json_encode($company)
        ];
        $queue->insertOneInTable($dto);
    }

