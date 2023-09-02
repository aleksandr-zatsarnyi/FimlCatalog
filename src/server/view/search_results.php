<?php
session_start();

if (isset($_SESSION['search_results'])) {
$movie = $_SESSION['search_results'];
unset($_SESSION['search_results']);
} else {
$movie = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
<h1>Search Results</h1>

<?php if (!empty($movie)) : ?>
    <ul>
        <?php foreach ($movie as $film) : ?>
            <li>id: <?= htmlspecialchars($film['id']) ?></li>
            <li>Title: <?= htmlspecialchars($film['title']) ?></li>
            <li>Release Year: <?= htmlspecialchars($film['release_year']) ?></li>
            <li>Format: <?= htmlspecialchars($film['format']) ?></li>
            <li>Actors: <?= htmlspecialchars($film['stars']) ?></li>
            <hr>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No movies found</p>
<?php endif; ?>

<a href="./../index.php">Back to Home</a>
</body>
</html>