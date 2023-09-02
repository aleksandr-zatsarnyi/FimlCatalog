<?php
session_start();

if (isset($_SESSION['operation_result'])) {
    $operationResult = $_SESSION['operation_result'];
    unset($_SESSION['operation_result']);
} else {
    $operationResult = null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Operation Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
        }

        .result-message {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
        }

        .error-message {
            color: #ff0000;
        }
    </style>
</head>
<body>
<h1>Operation Result</h1>

<?php if ($operationResult !== null) : ?>
    <div class="result-message <?php echo $operationResult['success'] ? '' : 'error-message'; ?>">
        <p><?= htmlspecialchars($operationResult['message']) ?></p>
    </div>
<?php else : ?>
    <p>Unknown Result</p>
<?php endif; ?>

<a href="./../index.php">Back to Home</a>
</body>
</html>
