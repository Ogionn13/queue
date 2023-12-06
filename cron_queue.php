<?php

use App\connectionMySQL\QueueTable;
use App\Controllers\QueueTableController;

const ROOT = __DIR__;

require_once ROOT . "/vendor/autoload.php";

$dbQueue = new QueueTable();

$queueManager = new QueueTableController($dbQueue);

if ($queueManager->isCanStart()){

    $queueManager->start();
    $queueManager->finish();
}

