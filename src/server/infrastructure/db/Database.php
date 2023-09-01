<?php

namespace App\Server\infrastructure\db;

use Exception;
use mysqli;
use mysqli_stmt;
use PDO;
use PDOException;

class Database {
    private PDO $connection;
    /**
     * @throws Exception
     */
    public function __construct() {
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error to connect to db " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}