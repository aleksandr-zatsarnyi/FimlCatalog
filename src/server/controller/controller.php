<?php

require_once(__DIR__ . './../infrastructure/db/config.php');
require_once(__DIR__ . './../infrastructure/db/Database.php');
require_once(__DIR__ . '/../../../vendor/autoload.php');

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;
use App\Server\infrastructure\repository\MovieRepository;
use App\Server\infrastructure\repository\UserRepository;
use App\Server\service\MoviesService;
use App\Server\service\UsersService;

session_start();

$dataBase = new Database();
$moviesService = new MoviesService(new MovieRepository($dataBase->getConnection()));
$userService = new UsersService(new UserRepository($dataBase->getConnection()));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    if ($userService->authenticateUser($login, $password)) {
        $_SESSION['user'] = $login;
        header('Location:./../index.php');
    } else {
        $_SESSION['operation_result'] = [
            'success' => false,
            'message' => 'no access to app'
        ];
        header('Location: ./../view/operation_result.php');
    }
    exit;
} else if (isset($_POST['register'])) {
    $login = $_POST['username'];
    $password = $_POST['password'];

    if ($userService->createUser($login, $password)) {
        header('Location:./../login.php');
    } else {
        $_SESSION['operation_result'] = [
            'success' => false,
            'message' => 'This user has already registered'
        ];
        header('Location: ./../view/operation_result.php');
    }
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === 'add_movie') {
        handleAddMovie($moviesService);
    } else if ($action === 'delete_movie') {
        handleDeleteMovie($moviesService);
    } else if ($action === 'load_film_from_file') {
        handleLoadFilmFromFile($moviesService);
    }

    header('Location: ./../view/operation_result.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_title') {
        handleFindMovieByTitle($moviesService);
    } else if (isset($_GET['action']) && $_GET['action'] === 'show_sorted_movies') {
        handleShowSortedMovies($moviesService);
    } else if (isset($_GET['action']) && $_GET['action'] === 'show_movie_info') {
        handleShowMovieInfo($moviesService);
    } else if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_actor') {
        handleFindMovieByActor($moviesService);
    }
}
function handleAddMovie(MoviesService $service) {
    $title = $_POST['title'];
    $release_year = $_POST['release_year'];
    $format = $_POST['format'];
    $actors = $_POST['actors'];

    $result = $service->addMovie(new MoviesDTO($title, $release_year, $format, explode(', ', $actors)));

    $_SESSION['operation_result'] = [
        'success' => $result,
        'message' => $result ? 'Film was added successfully' :
            'Cant add the film'
    ];
}

function handleDeleteMovie(MoviesService $service) {
    $movieId = $_POST['movie_id'];
    $result = $service->removeMovie($movieId);

    $_SESSION['operation_result'] = [
        'success' => $result,
        'message' => $result ? 'Film with id:' . $movieId . ' was removed successfully' :
            'something wrong'
    ];
}

function handleLoadFilmFromFile(MoviesService $service) {
    if ($_FILES["movie_file"]["error"] == UPLOAD_ERR_OK) {
        $tmp_file = $_FILES["movie_file"]["tmp_name"];

        $fileContent = file_get_contents($tmp_file);
        $moviesData = explode("\n\n", $fileContent);
        $moviesDTOs = [];

        foreach ($moviesData as $movieInfo) {
            $lines = explode("\n", $movieInfo);
            $title = '';
            $releaseYear = '';
            $format = "";
            $stars = [];

            if (!empty($movieInfo)) {
                foreach ($lines as $line) {
                    list($key, $value) = explode(": ", $line, 2);

                    switch ($key) {
                        case "Title":
                            $title = $value;
                            break;
                        case "Release Year":
                            $releaseYear = $value;
                            break;
                        case "Format":
                            $format = $value;
                            break;
                        case "Stars":
                            $stars = explode(", ", $value);
                            break;
                    }
                }
                $moviesDTO = new MoviesDTO($title, $releaseYear, $format, $stars);
                $moviesDTOs[] = $moviesDTO;
            }
        }
    }
    if (isset($moviesDTOs)) {
        $result = $service->saveAllMovies($moviesDTOs);

        $_SESSION['operation_result'] = [
            'success' => $result,
            'message' => $result ? 'Films was added successfully' :
                'Cant add the films'
        ];
    }
}

function handleFindMovieByTitle(MoviesService $service) {
    $movies = $service->findMoviesByTitle($_GET['search_title']);
    $_SESSION['search_results'] = $movies;
    header('Location: /view/search_results.php');
    exit;
}

function handleShowSortedMovies(MoviesService $service) {
    $movies = $service->getAllMovies();
    $_SESSION['search_results'] = $movies;
    header('Location: ./view/search_results.php');
    exit;
}

function handleShowMovieInfo(MoviesService $service) {
    $movies = $service->getMovies($_GET['movie_id']);
    $_SESSION['search_results'] = $movies;
    header('Location: /view/search_results.php');
    exit;
}

function handleFindMovieByActor(MoviesService $service) {
    $movies = $service->getMoviesByActorName($_GET['actor_name']);
    $_SESSION['search_results'] = $movies;
    header('Location: /view/search_results.php');
    exit;
}