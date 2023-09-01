<?php

namespace App\Server\infrastructure\db;

use Exception;
use mysqli;
use mysqli_stmt;

class Database {
    private mysqli $connection;
    private mysqli_stmt $statement;

    /**
     * @throws Exception
     */
    public function __construct() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->connection->connect_error) {
            //throw new Exception('Connection failed: ' . $this->connection->connect_error);
        }
    }

    /**
     * @throws Exception
     */
    public function query($sql)
    {
        $result = $this->connection->query($sql);

        if (!$result) {
            throw new Exception('Query error: ' . $this->connection->error);
        }

        return $result;
    }

    public function init(): void {
        $sqlQueries = file_get_contents(INIT_PATH);

        $queries = explode(';', $sqlQueries);

        foreach ($queries as $query) {
            $this->connection->query($query);
        }
    }

    public function close(): void {
        $this->connection->close();
    }

    public function prepareStatement(string $sql) {
        $this->statement = mysqli_prepare($this->connection, $sql);
    }

    public function bindParameters(string $type , string... $params) {
        $args = [$this->statement, $type];
        foreach ($params as &$param) {
            $args[] = &$param;
        }

        call_user_func_array('mysqli_stmt_bind_param', $args);
    }

    public function execute(): bool {
        return mysqli_stmt_execute($this->statement);
    }

    public function getResult() {
        return $this->statement->get_result();
    }

    public function closeStatement() {
        $this->statement->close();
    }
}