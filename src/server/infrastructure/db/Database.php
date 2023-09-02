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

            $this->createTables();
        } catch (PDOException $e) {
            die("Error to connect to db " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->connection;
    }

    private function createTables() {
        $sql = "CREATE TABLE IF NOT EXISTS movies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            release_year INT NOT NULL,
            format VARCHAR(20) NOT NULL,
            stars VARCHAR(255) NOT NULL
        )";

        $this->connection->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(30) NOT NULL UNIQUE,
            password VARCHAR(100) NOT NULL
        )";

        $this->connection->exec($sql);
    }
}