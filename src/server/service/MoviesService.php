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
        return $this->repository->save($dto);
    }

    public function getAllMovies() {
        return $this->repository->getAll();
    }

    public function removeMovie(int $id): bool {
        return $this->repository->removeMovie($id);
    }

    public function findMoviesByTitle(string $title) {
        return $this->repository->getByTitle($title);
    }
}