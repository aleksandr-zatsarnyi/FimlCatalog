<?php

use App\Server\controller\MovieController;

require_once('controller/controller.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
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

<form id="delete_movie_form" class="hidden-form" method="POST" action="controller/controller.php">
    <input type="hidden" name="action" value="delete_movie">
    <input type="text" name="movie_id" placeholder="ID of Film" required><br>
    <button type="submit">Delete the film</button>
</form>

<form id="add_movie_form" class="hidden-form" method="POST" action="controller/controller.php">
    <input type="hidden" name="action" value="add_movie">
    <input type="text" name="title" placeholder="Title" required><br>
    <input type="text" name="release_year" placeholder="Release Year" required><br>
    <select name="format" required>
        <option value="VHS">VHS</option>
        <option value="DVD">DVD</option>
        <option value="Blu-Ray">Blu-Ray</option>
    </select><br>
    <input type="text" name="actors" placeholder="Actors (comma delimiter: Actor1, Actor2)" required><br>
    <button type="submit">Add Film</button>
</form>

<form id="find_movie_form" class="hidden-form" method="GET" action="controller/controller.php">
    <input type="hidden" name="action" value="find_movie_by_title">
    <input type="text" name="search_title" placeholder="Name of Film" required><br>
    <button type="submit">Find Film</button>
</form>

<form id="find_movie_by_actor_form" class="hidden-form" method="GET" action="controller/controller.php">
    <input type="hidden" name="action" value="find_movie_by_actor">
    <input type="text" name="actor_name" placeholder="Actor's name" required><br>
    <button type="submit">Find film</button>
</form>

<form id="show_movie_info_form" class="hidden-form" method="GET" action="controller/controller.php">
    <input type="hidden" name="action" value="show_movie_info">
    <input type="text" name="movie_id" placeholder="ID of Film" required><br>
    <button type="submit">Show film info</button>
</form>

<form id="load_film_from_file" class="hidden-form" method="POST" action="controller/controller.php" enctype="multipart/form-data">
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