<?php

namespace App\Server\service;

use App\Server\infrastructure\repository\UserRepository;

class UsersService {

    private UserRepository $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }


    public function authenticateUser(string $login, string $password): bool {
        $user = $this->repository->getUserByUsername($login);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function createUser(string $login, string $password): bool {
        return $this->repository->createUser($login, $this->hashPassword($password));
    }

    private function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

}