<?php

namespace App\Server\service;

use App\Server\dto\MoviesDTO;
use App\server\infrastructure\repository\MovieRepository;

class MoviesService {

    private MovieRepository $repository;

    /**
     * @param MovieRepository $repository
     */
    public function __construct(MovieRepository $repository) {
        $this->repository = $repository;
    }

    public function addMovie(MoviesDTO $dto): bool {
        return $this->repository->addMovie($dto);
    }

    public function getAllMovies() {
        return $this->repository->getAllMovies();
    }

    public function removeMovie(int $id): bool {
        return $this->repository->deleteMovie($id);
    }

    public function findMoviesByTitle(string $title) {
        return $this->repository->findByTitle($title);
    }

    public function getMovies(int $id) {
        return $this->repository->findByID($id);
    }

    public function getMoviesByActorName(string $name) {
        return $this->repository->findByActorName($name);
    }
}