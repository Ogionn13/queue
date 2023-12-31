<?php

namespace App\connectionMySQL;

use App\Config;
use App\Controllers\DataTransformerController;
use PDO\DB;

abstract class DataBaseManager
{
    protected DB $db;
    protected string $table;

    protected DataTransformerController $dataTransformerController;


    public function __construct()
    {
        $this->db = new DB(Config::HOST, Config::PORT, Config::NAME_DB, Config::USER, Config::PASSWORD);
        $this->setTableName();
        $this->dataTransformerController = new DataTransformerController();
    }

    abstract protected function setTableName(): void;

    public function select($params, $columns = "*")
    {
        if (is_array($columns)) {
            $columns = join(", ", $columns);
        }
        $query = "SELECT $columns FROM {$this->table} " . $params;
        return $this->db->query($query);
    }

    public function insertOneInTable(array $dto)
    {
        $this->db->insert($this->table, $this->changeBoolToInt($dto));
        return $this;
    }

    protected function changeBoolToInt(array $dto): array
    {
        foreach ($dto as $key => $value) {
            if (is_bool($value)) {
                $dto[$key] = (int)$value;
            }
        }
        return $dto;
    }

    public function insertInTableMulti(array $dtoArr)
    {
        $this->db->insertMulti($this->table, $this->changeBoolToIntMulti($dtoArr));
        return $this;
    }

    protected function changeBoolToIntMulti(array $dtoArr): array
    {
        foreach ($dtoArr as $parentKey => $dto) {
            foreach ($dto as $key => $value) {
                if (is_bool($value)) {
                    $dtoArr[$parentKey][$key] = (int)$value;
                }
            }
        }
        return $dtoArr;
    }

    public function updateById(int $id, $where = [])
    {
        $this->db->update($this->table, $where, ['id' => $id]);
    }


    public function getDb()
    {
        return $this->db;
    }

}