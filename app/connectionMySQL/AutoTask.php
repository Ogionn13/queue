<?php

namespace App\connectionMySQL;

use App\Config;

class AutoTask extends DataBaseManager
{

    function setTableName(): void
    {
        $this->table = Config::TABLE_AUTO_TASK;
    }

    public function getCompanies()
    {
        $findDiff = time() - 3201600;
        $last_check = time() - 86400;

        $query = "WHERE (last_task_with_result is not null) and (last_task_with_result < $findDiff) and (last_task_status = 'unset') and ((last_check < $last_check) or last_check is null)";
        return $this->select($query, ["company_id", "last_task_with_result"]);

    }
}