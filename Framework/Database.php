<?php

namespace Framework;

use Exception;
use PDO;
use PDOException;

class Database
{
    public $conn;

    /**
     * Construct of DB class
     *
     * @param array $config
     * @throws Exception
     */
    public function __construct(array $config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        }
    }

    /**
     * Query the database
     *
     * @param $query
     * @param array $params
     * @return PDOStatement
     * @throws Exception
     */
    public function query($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            foreach ($params as $param => $value) {
                $stmt->bindValue(":$param", $value, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Database query failed: {$e->getMessage()}");
        }
    }
}
