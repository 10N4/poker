<?php

namespace poker_model;

use PDOStatement;

require_once "server/db.php";
require_once "server/function.php";


abstract class DBO
{
    protected const ID = 'id';
    private $id = -1;

    private $values = array();

    public function __construct()
    {
    }

    // region DB Control

    public static function loadById($id): DBO
    {
        return self::load(self::ID, $id)[0];
    }

    public static function load($field, $value, $options = array()): array
    {
        return array();
    }

    public function create(): void
    {
        return;
        if (!$this->isCreated()) {
            return;
        }

        $table = static::getTable();
        $columnString = implode(",", static::getColumns());
        $paramString = implode(",", $this->getKeysAsParams());

        $sql = "INSERT INTO {$table} {$columnString} VALUES ({$paramString})";
        $stmt = pdo()->prepare($sql);
        $stmt = $this->getStmtBind($stmt);
        $stmt->execute() or dieSqlError("8e4f141a-9cf2-4d4c-8def-e916964680c8");

        $sql = "SELECT MAX(" . self::ID . ") as max_id FROM {$table} LIMIT 1";
        $result = pdo()->query($sql)->fetch(\PDO::FETCH_ASSOC);

        $this->id = $result["max_id"];
    }

    public function update(): void
    {
        return;

    }

    public function delete(): void
    {
        return;

    }

    // endregion

    // region getter and setter

    public function getId(): int
    {
        return $this->id;
    }

    public function isCreated(): bool
    {
        return $this->id == -1;
    }

    protected function getValue($field)
    {
        return $this->values[$field];
    }

    protected function setValue($field, $value)
    {
        $this->values[$field] = $value;
    }

    // endregion

    // region helper


    private function getKeysAsParams(): array
    {
        $params = array();
        foreach ($this->values as $key => $value) {
            $params[] = ':' . $key;
        }
        return $params;
    }

    /**
     * @param PDOStatement $stmt
     * @return PDOStatement
     */
    private function getStmtBind($stmt): PDOStatement
    {
        foreach ($this->values as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        return $stmt;
    }


    protected abstract static function getTable(): string;

    protected abstract static function getColumns(): array;

    public static function forEachInstance($fun): void
    {

    }

    public function toJson(...$fields)
    {
        if (count($fields) == 0) {
            return json_encode($this->values);
        }
        $encodeValues = array();
        foreach ($this->values as $key => $value) {
            if (in_array($key, $fields)) {
                $encodeValues[$key] = $value;
            }
        }
        return json_encode($encodeValues);
    }

    // endregion
}