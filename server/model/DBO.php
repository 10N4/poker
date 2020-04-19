<?php

namespace poker_model;

use PDOStatement;

require_once "server/global.php";

/**
 * Class DBO
 * @package poker_model
 */
abstract class DBO
{
    const ID = 'id';
    const defaultId = 0;

    private $id = self::defaultId;
    private $values = array();

    /**
     * Prevents the use of a constructor with parameters in subclasses. Use an init function instead.
     * DBO constructor.
     */
    public function __construct()
    {
    }

    // region getter and setter

    public function getId(): int
    {
        return $this->id;
    }

    public function isInserted(): bool
    {
        return $this->id != self::defaultId;
    }

    protected function getValue($field)
    {
        return $this->values[$field];
    }

    protected function setValue($field, $value)
    {
        if ($field == self::ID) {
            dieFatalError('30da9b02-4e90-49d5-9c49-e79f3e794fa6');
        }
        $this->values[$field] = $value;
    }

    // endregion

    // region DB Control

    /**
     * Returns the instance with the given id
     * @param $id
     * @return mixed
     */
    public static function loadById($id)
    {
        return self::load(self::ID, $id)[0];
    }

    /**
     * Returns all instances matching the given conditions
     * @param $field
     * @param $value
     * @param array $options
     * @return array
     */
    public static function load($field, $value, $options = array()): array
    {
        if (!static::escapteField($field)) {
            dieFatalError('4ada65f9-0953-4467-a361-0f4e4ceea869');
        }
        $table = static::getTable();
        $sql = "SELECT * FROM {$table} WHERE {$field} = :value";
        $stmt = pdo()->prepare($sql);
        $stmt->bindValue(':value', $value);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $objectArray = array();
        foreach ($result as $entry) {
            $object = new static();
            $object->values = $entry;
            $objectArray[] = $object;
        }

        return $objectArray;
    }

    /**
     * Inserts a new database entry for the instance if not done yet
     */
    public function insert(): void
    {
        if ($this->isInserted()) {
            return;
        }

        $table = static::getTable();
        $columnString = implode(",", static::getColumns());
        $paramString = implode(",", $this->getKeysAsParams());

        $sql = "INSERT INTO {$table} ({$columnString}) VALUES ({$paramString})";
        $stmt = pdo()->prepare($sql);
        $stmt = $this->getStmtBind($stmt);
        $stmt->execute() or dieSqlError("8e4f141a-9cf2-4d4c-8def-e916964680c8");

        $sql = "SELECT MAX(" . self::ID . ") as max_id FROM {$table} LIMIT 1";
        $result = pdo()->query($sql)->fetch(\PDO::FETCH_ASSOC);

        $this->id = $result["max_id"];
    }

    /**
     * Updates the database entry of the instance
     */
    public function update(): void
    {
        $table = static::getTable();
        $id = self::ID;
        $updateQueryString = $this->getUpdateQueryString();
        $sql = "UPDATE {$table} SET {$updateQueryString} WHERE {$id} = {$this->getId()}";
        $stmt = pdo()->prepare($sql);
        $stmt = $this->getStmtBind($stmt);
        $stmt->execute() or dieSqlError('85ac03b3-f575-48dd-aed8-f4ecf763c016');
    }

    /**
     * Deletes the instance from the database
     */
    public function delete(): void
    {
        $table = static::getTable();
        $id = static::ID;
        $sql = "DELETE FROM {$table} WHERE {$id} = {$this->getId()}";
        pdo()->query($sql) or dieSqlError('e70e2c41-689b-4763-9841-87f4d5cf6676');

        $this->id = self::defaultId;
    }

    // endregion

    // region tools

    /**
     * Returns the table of the database the class is made for
     * @return string
     */
    protected abstract static function getTable(): string;

    /**
     * Returns all columns of the database the class is made for
     * @return array
     */
    protected abstract static function getColumns(): array;

    /**
     * Executes the given function for all instances selcted by the given load-function
     * @param $fun function to be executed
     * @param $load function to load the instances on which the function is executed
     */
    public static function forEachInstance($fun, $load): void
    {

    }

    /**
     * Returns a json of the instance
     * Only writes the given fields to the json if there is at least one field given, otherwise all fields are written
     * @param mixed ...$fields
     * @return false|string
     */
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

    private static function escapteField($field)
    {
        if ($field === static::ID || in_array($field, static::getColumns())) {
            return true;
        }
        return false;
    }

    private function getUpdateQueryString()
    {
        $result = '';
        foreach ($this->values as $key => $value) {
            $result .= $key . ' = ' . ':' . $value . ', ';
        }
        return substr($result, 0, strlen($result) - 1);
    }

    // endregion
}