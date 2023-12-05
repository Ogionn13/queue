<?php

use App\connectionMySQL\Queue;
use App\QueueManager;

const ROOT = __DIR__;

require_once ROOT . "/vendor/autoload.php";

$dbQueue = new Queue();

$queueManager = new QueueManager($dbQueue);

if ($queueManager->isCanStart()){

    $queueManager->start();
    $queueManager->finish();
}

