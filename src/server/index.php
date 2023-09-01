<?php

require_once('./infrastructure/db/config.php');
require_once('./infrastructure/db/Database.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

use App\Server\dto\MoviesDTO;
use App\Server\infrastructure\db\Database;
use App\Server\infrastructure\repository\MovieRepository;
use App\Server\service\MoviesService;

$dataBase = new Database();
try {
    $dataBase->init();
} catch (Exception $e) {
    echo 'error';
};

$service = new MoviesService(new MovieRepository($dataBase));

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
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'find_movie_by_title') {
        $movie = $service->findMoviesByTitle($_GET['search_title']);
    }
    if (isset($_GET['action']) && $_GET['action'] === 'show_sorted_movies') {
        $sortedMovies = $service->getAllMovies();

        //echo json_encode($sortedMovies);
        //exit;
    }
}

//$movies = getAllMovies();
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
    <li><a href="#" onclick="toggleForm('add_movie_form');">Додати фільм</a></li>
    <li><a href="#" onclick="toggleForm('delete_movie_form');">Видалити фільм</a></li>
    <li><a href="#" onclick="toggleForm('find_movie_form');">Знайти фільм за назвою</a></li>
    <li><a href="#" onclick="toggleForm('show_movie_info_form');">Показати інформацію про фільм</a></li>
    <li><a href="#" onclick="loadSortedMovies();">Показати список фільмів відсортованих за назвою</a></li>
</ul>

<form id="delete_movie_form" class="hidden-form" method="POST" action="index.php">
    <input type="hidden" name="action" value="delete_movie">
    <input type="text" name="movie_id" placeholder="ID фільму для видалення" required><br>
    <button type="submit">Видалити фільм</button>
</form>

<form id="add_movie_form" class="hidden-form" method="POST" action="index.php">
    <input type="hidden" name="action" value="add_movie">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="text" name="release_year" placeholder="Release Year" required><br>
    <input type="text" name="format" placeholder="Format" required><br>
    <input type="text" name="actors" placeholder="Actors (роздільники: кома, наприклад, Actor1, Actor2)" required><br>
    <button type="submit">Додати фільм</button>
</form>

<form id="find_movie_form" class="hidden-form" method="GET" action="index.php">
    <input type="hidden" name="action" value="find_movie_by_title">
    <input type="text" name="search_title" placeholder="Назва фільму" required><br>
    <button type="submit">Знайти фільм</button>
</form>

<form id="show_movie_info_form" class="hidden-form" method="POST" action="index.php">
    <input type="hidden" name="action" value="show_movie_info">
    <input type="text" name="movie_id" placeholder="ID фільму" required><br>
    <button type="submit">Показати інформацію</button>
</form>

<?php
if (!empty($movie)) {
    echo '<div id="searchResults">';
    echo '<h2>Search Result</h2>';
    echo '<ul>';
    foreach ($movie as $film) {
        echo '<hr>';
        echo '<li>' . htmlspecialchars($film['title']) . '</li>';
        echo '<li>' . htmlspecialchars($film['release_year']) . '</li>';
        echo '<li>' . htmlspecialchars($film['format']) . '</li>';
        echo '<li>' . htmlspecialchars($film['actors']) . '</li>';
        echo '<hr>';
    }
    echo '</ul>';
} elseif (isset($movie)) {
    echo '<p>The movie not found</p>';
}
?>

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

    function loadSortedMovies() {
        fetch('server.php?action=show_sorted_movies')
            .then(response => response.json())
            .then(data => {
                displaySortedMovies(data);
            })
            .catch(error => {
                console.error('Помилка отримання даних з сервера: ' + error);
            });
    }

    function displaySortedMovies(movies) {
    }
</script>
</html>