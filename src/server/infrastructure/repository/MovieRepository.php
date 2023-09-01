<?php

namespace App\Server\infrastructure\repository;

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;
use PDO;

class MovieRepository {

    private PDO $db;

    public function __construct(PDO $driver) {
        $this->db = $driver;
    }

    public function getAllMovies() {
        $query = "SELECT * FROM movies ORDER BY 'title'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addMovie(MoviesDTO $dto): bool {
        $title = $dto->getTitle();
        $release_year = $dto->getReleaseYear();
        $format = $dto->getFormat();
        $stars = implode(',', $dto->getStars());

        $query = "INSERT INTO movies (title, release_year, format, stars) VALUES (:title, :release_year, :format, :stars)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':release_year', $release_year);
        $stmt->bindParam(':format', $format);
        $stmt->bindParam(':stars', $stars);
        return $stmt->execute();
    }

    public function deleteMovie($id) {
        $query = "DELETE FROM movies WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function findByTitle(string $title) {
        $query = "SELECT * FROM movies WHERE title = :title";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id) {
        $query = "SELECT * FROM movies WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByActorName(string $name) {
        $query = "SELECT * FROM movies WHERE stars LIKE CONCAT('%', :actor_name, '%')";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':actor_name', $name);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}