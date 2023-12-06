<?php

use App\Config;
use App\connectionMySQL\AutoTask;
use App\connectionMySQL\QueueTable;


const ROOT = __DIR__ . "/..";
require_once ROOT . "/vendor/autoload.php";

$autoTask = new AutoTask();
$queueTable = new QueueTable();

$companies = $autoTask->getCompanies();


foreach ($companies as $company){
    $dto  = [
        "urlHook" => "https://hub.integrat.pro/api/trendAgent/site/integration-amoCRM/company_activity/queue_check_last_task.php",
        "inputData" => json_encode($company)
    ];
    if ($queueTable->isUniqueInputData($dto['inputData'])){
        $queueTable->insertOneInTable($dto);
    }

}


//
//    $companies = [
//        [
//            "last_task_with_result"=>1697186169,
//            "company_id"=>3382563
//        ],
//        [
//            "last_task_with_result"=>1697116169,
//            "company_id"=>33825640
//        ],
//        [
//            "last_task_with_result"=>1699186169,
//            "company_id"=>33825641
//        ],
//    ];
//
//    foreach ($companies as $company){
//        $dto  = [
//            "urlHook" => "https://hub3.integr3at.pro/api/trendAgent/queue/dev/test_hook.php",
//            "inputData" => json_encode($company)
//        ];
//            if ($queue->isUniqueInputData($dto['inputData'])){
//                $queue->insertOneInTable($dto);
//            }
//    }

