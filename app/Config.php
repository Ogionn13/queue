<?php

namespace App;

class Config
{
const
        HOST = "localhost",
        PORT  = "3306",
        NAME_DB = "u0574215_trandagent",
        USER = 'root',
        PASSWORD = '',
//        USER = 'u0574215_default',
//        PASSWORD = 'RnbN2acswL4E9o3E',
        TABLE_QUEUE = "queue",
        TABLE_AUTO_TASK = "auto_tasks";


const MAX_ATTEMPS = 3;
const TIME_OF_WORK = 240;
const DIR_PDO_LOG = ROOT."/logs/PDO/";
const LAST_TIME_START_FILE = ROOT."/data_files/lastTimeStart.json";
}
