<?php

namespace App\Models;

use Exception;
use Framework\Database;
use PDO;

abstract class Model
{
    protected static $db;

    /**
     * Initialize the database connection
     *
     * @throws Exception
     */
    protected static function initDb()
    {
        if (self::$db === null) {
            $config = require basePath('config/db.php');
            self::$db = new Database($config);
        }
    }

    /**
     * Get the table name from the derived class
     *
     * @return string
     */
    abstract protected static function getTableName();

    /**
     * Retrieve all records from the table
     *
     * @return array
     * @throws Exception
     */
    public static function all()
    {
        self::initDb();
        $tableName = static::getTableName();
        $query = "SELECT * FROM " . $tableName;
        $stmt = self::$db->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Find a record by its id
     *
     * @param mixed $id
     * @return object|false
     * @throws Exception
     */
    public static function find($id)
    {
        self::initDb();
        $tableName = static::getTableName();

        $query = "SELECT * FROM $tableName WHERE id = :id";
        $stmt = self::$db->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Find records by given conditions
     *
     * @param array $conditions
     * @return array
     * @throws Exception
     */
    public static function where(array $conditions)
    {
        self::initDb();
        $tableName = static::getTableName();

        $placeholders = [];
        foreach ($conditions as $key => $value) {
            $placeholders[] = "$key = :$key";
        }
        $whereClause = implode(' AND ', $placeholders);

        $query = "SELECT * FROM $tableName WHERE $whereClause";
        $stmt = self::$db->conn->prepare($query);

        foreach ($conditions as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Create a new record in the table
     *
     * @param array $data
     * @return object
     * @throws Exception
     */
    public static function create(array $data)
    {
        self::initDb();
        $tableName = static::getTableName();

        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = self::$db->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        if ($stmt->execute()) {
            $id = self::$db->conn->lastInsertId();
            return self::find($id); // Return the newly created record
        } else {
            throw new Exception("Failed to create record");
        }
    }

    /**
     * Delete a record by its id
     *
     * @param mixed $id
     * @return bool
     * @throws Exception
     */
    public static function delete($id)
    {
        self::initDb();
        $tableName = static::getTableName();

        $query = "DELETE FROM $tableName WHERE id = :id";
        $stmt = self::$db->conn->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Update a record by its id
     *
     * @param mixed $id
     * @param array $data
     * @return object
     * @throws Exception
     */
    public static function update($id, array $data)
    {
        self::initDb();
        $tableName = static::getTableName();

        $setClause = [];
        foreach ($data as $key => $value) {
            $setClause[] = "$key = :$key";
        }
        $setClauseString = implode(', ', $setClause);

        $query = "UPDATE $tableName SET $setClauseString WHERE id = :id";
        $stmt = self::$db->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return self::find($id); // Return the updated record
        } else {
            throw new Exception("Failed to update record");
        }
    }
}
