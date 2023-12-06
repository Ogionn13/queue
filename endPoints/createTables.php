<?php


use App\connectionMySQL\TableCreator;

const ROOT = __DIR__."/..";

require_once ROOT . "/vendor/autoload.php";


$creator = new TableCreator();
$creator->createAllTables();