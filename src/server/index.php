<?php

require_once('./infrastructure/db/config.php');
require_once('./infrastructure/db/Database.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;
use App\Server\infrastructure\repository\MovieRepository;
use App\Server\service\MoviesService;

session_start();

$dataBase = new Database();
$service = new MoviesService(new MovieRepository($dataBase->getConnection()));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add_movie') {
        $title = $_POST['title'];
        $release_year = $_POST['release_year'];
        $format = $_POST['format'];
        $actors = $_POST['actors'];

        $result = $service->addMovie(new MoviesDTO($title, $release_year, $format, explode(', ', $actors)));
    } else if ($action === 'delete_movie') {
        $movieId = $_POST['movie_id'];
        $result = $service->removeMovie($movieId);

        if ($result) {
            echo "Фільм був успішно видалений.";
        }
    } else if ($action === 'load_film_from_file') {
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
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_title') {
        $movies = $service->findMoviesByTitle($_GET['search_title']);
        $_SESSION['search_results'] = $movies;
        header('Location: search_results.php');
        exit;
    }
    if (isset($_GET['action']) && $_GET['action'] === 'show_sorted_movies') {
        $movies = $service->getAllMovies();
        $_SESSION['search_results'] = $movies;
        header('Location: search_results.php');
        exit;
    }
    if (isset($_GET['action']) && $_GET['action'] === 'show_movie_info') {
        $movies = $service->getMovies($_GET['movie_id']);
        $_SESSION['search_results'] = $movies;
        header('Location: search_results.php');
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_actor') {
        $movies = $service->getMoviesByActorName($_GET['actor_name']);
        $_SESSION['search_results'] = $movies;
        header('Location: search_results.php');
        exit;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie App</title>
</head>

<style>
    .hidden-form {
        display: none;
    }
</style>

<body>
<h1>Welcome</h1>
<h2>Menu</h2>
<ul>
    <li><a href="#" onclick="toggleForm('add_movie_form');">Add film</a></li>
    <li><a href="#" onclick="toggleForm('delete_movie_form');">Remove film</a></li>
    <li><a href="#" onclick="toggleForm('find_movie_form');">Find film by Title</a></li>
    <li><a href="#" onclick="toggleForm('find_movie_by_actor_form');">Find film by actor name</a></li>
    <li><a href="#" onclick="toggleForm('show_movie_info_form');">Show film information</a></li>
    <li><a href="index.php?action=show_sorted_movies">Show all films sorted by title</a></li>
    <li><a href="#" onclick="toggleForm('load_film_from_file');">load film from file</a></li>
</ul>

<form id="delete_movie_form" class="hidden-form" method="POST" action="index.php">
    <input type="hidden" name="action" value="delete_movie">
    <input type="text" name="movie_id" placeholder="ID of Film" required><br>
    <button type="submit">Delete the film</button>
</form>

<form id="add_movie_form" class="hidden-form" method="POST" action="index.php">
    <input type="hidden" name="action" value="add_movie">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="text" name="release_year" placeholder="Release Year" required><br>
    <input type="text" name="format" placeholder="Format" required><br>
    <input type="text" name="actors" placeholder="Actors (comma delimiter: Actor1, Actor2)" required><br>
    <button type="submit">Add Film</button>
</form>

<form id="find_movie_form" class="hidden-form" method="GET" action="index.php">
    <input type="hidden" name="action" value="find_movie_by_title">
    <input type="text" name="search_title" placeholder="Name of Film" required><br>
    <button type="submit">Find Film</button>
</form>

<form id="find_movie_by_actor_form" class="hidden-form" method="GET" action="index.php">
    <input type="hidden" name="action" value="find_movie_by_actor">
    <input type="text" name="actor_name" placeholder="Actor's name" required><br>
    <button type="submit">Find film</button>
</form>

<form id="show_movie_info_form" class="hidden-form" method="GET" action="index.php">
    <input type="hidden" name="action" value="show_movie_info">
    <input type="text" name="movie_id" placeholder="ID of Film" required><br>
    <button type="submit">Show film info</button>
</form>

<form id="load_film_from_file" class="hidden-form" method="POST" action="index.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="load_film_from_file">
    <input type="file" name="movie_file" accept=".txt">
    <input type="submit" value="load">
</form>

</body>
<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }
</script>
</html>