<?php
// Отримати ідентифікатор фільму з параметра "id" у URL
$movieId = $_GET['id'];

// Отримати інформацію про фільм з бази даних (приклад)
$movieDetails = $service->getMovieDetails($movieId); // Ваш сервіс, який повертає деталі фільму
?>

<!DOCTYPE html>
<html>
<head>
    <title>Деталі фільму</title>
</head>
<body>
    <h1>Деталі фільму</h1>

    <h2><?php echo $movieDetails['title']; ?></h2>
    <p>Рік випуску: <?php echo $movieDetails['release_year']; ?></p>
    <p>Формат: <?php echo $movieDetails['format']; ?></p>
    <p>Актори: <?php echo $movieDetails['actors']; ?></p>

    <a href="index.php">Повернутися на головну сторінку</a>
</body>
</html>
