<?php

namespace App\Server\infrastructure\repository;

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;

class MovieRepository {

    private DataBase $driver;

    public function __construct(DataBase $driver) {
        $this->driver = $driver;
    }

    public function save(MoviesDTO $dto): bool {
        $sql = 'INSERT INTO `movies`(`title`, `release_year`, `format`, `actors`) VALUES (?, ?, ?, ?)';
        $this->driver->prepareStatement($sql);
        $this->driver->bindParameters('siss', $dto->getTitle(), $dto->getReleaseYear(), $dto->getFormat(), implode(', ', $dto->getStars()));
        return $this->driver->execute();
    }

    public function getAll() {
        return $this->driver->query('SELECT * FROM `movies` ORDER BY `title`');
    }

    public function getByTitle(string $title) {
        $sql =  'SELECT * FROM `movies` WHERE `title` = ?';
        $this->driver->prepareStatement($sql);
        $this->driver->bindParameters('s', $title);

        return $this->driver->execute();
    }

    public function findByActorName(string $name) {
        $sql =  'SELECT * FROM `movies` WHERE `title` = ?';
        $this->driver->prepareStatement($sql);
        $this->driver->bindParameters('s', $name);

        return $this->driver->execute();
    }

    public function removeMovie(int $id) {
        $sql = 'DELETE FROM `movies` WHERE id = ?';
        $this->driver->prepareStatement($sql);
        $this->driver->bindParameters('i', $id);

        return $this->driver->execute();
    }
}