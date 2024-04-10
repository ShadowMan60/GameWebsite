<?php

session_start();
require_once '../PHP/Database.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../PHP/login.PHP");
    exit();
}

$username = $_SESSION['username'];

$db = new Database("localhost", "gameweb", "root", "root");
$conn = $db->getConnection();


function insertScore($conn, $username, $score) {
    try {
        $stmt = $conn->prepare("INSERT INTO cubper_scores (username, score) VALUES (:username, :score)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':score', $score);
        $stmt->execute();
        echo "Score inserted successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_POST['score'])) {
    $score = $_POST['score'];
    insertScore($conn, $username, $score);
}

?>


<div class="text">
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>Hello, <?php echo $username; ?>. Welcome to our website.</p>
    <p><a href="../PHP/logout.php">Logout</a></p>
</div>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <link rel="stylesheet" href="cubper.css">
</head>

<body>

<canvas id="GameField"></canvas>
<p id="score-field">Score: 0</p>
<div id="game-over-text" style="display: none;">
    You Failed<br>
    <button id="retry-button">Retry</button>
</div>

<script>
    // php server url for in javascript
    let scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
</script>

<script src="cubper.js"></script>

</body>
</html>