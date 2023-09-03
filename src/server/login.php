<?php
require_once('controller/controller.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

<form method="POST" action="controller/controller.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="login">Log In</button>
    <button type="submit" name="register">Register</button>
</form>

</body>
</html>
