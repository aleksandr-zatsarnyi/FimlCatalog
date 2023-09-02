<?php

namespace App\Server\infrastructure\repository;

use PDO;

class UserRepository {

    private PDO $db;

    public function __construct(PDO $driver) {
        $this->db = $driver;
    }

    public function createUser($login, $password) {

        $stmt = $this->db->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    public function getUserByUsername($login) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}