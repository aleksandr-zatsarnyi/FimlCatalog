<?php

namespace App\Server\controller;

require_once('./infrastructure/db/config.php');
require_once('./infrastructure/db/Database.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

session_start();

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;
use App\Server\infrastructure\repository\MovieRepository;
use App\Server\service\MoviesService;

class MovieController {
    private $service;

    public function __construct() {
        $dataBase = new Database();
        $this->service = new MoviesService(new MovieRepository($dataBase->getConnection()));
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];

            if ($action === 'add_movie') {
                $this->handleAddMovie();
            } else if ($action === 'delete_movie') {
                $this->handleDeleteMovie();
            } else if ($action === 'load_film_from_file') {
                $this->handleLoadFilmFromFile();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_title') {
                $this->handleFindMovieByTitle();
            } else if (isset($_GET['action']) && $_GET['action'] === 'show_sorted_movies') {
                $this->handleShowSortedMovies();
            } else if (isset($_GET['action']) && $_GET['action'] === 'show_movie_info') {
                $this->handleShowMovieInfo();
            } else if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_actor') {
                $this->handleFindMovieByActor();
            }
        }
    }

    private function handleAddMovie() {
    }

    private function handleDeleteMovie() {
    }

    private function handleLoadFilmFromFile() {
    }

    private function handleFindMovieByTitle() {
    }

    private function handleShowSortedMovies() {
    }

    private function handleShowMovieInfo() {
    }

    private function handleFindMovieByActor() {
    }
}