<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

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
        $stmt = $conn->prepare("INSERT INTO highscores (username, score) VALUES (:username, :score)");
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris</title>
    <link rel="stylesheet" href="Tetris.css">
</head>
<body>
    <header>

    </header>
    
    <div id="linesContainer">
        <span>Lines -</span>
        <span id="lines">0</span>
    </div>
    <canvas id="board" width="220" height="420"></canvas>
    <div id="gameOverContainer" style="display: none;">
        <span id="gameOver">Game over!</span>
        <br>
        <button id="restartButton">Restart</button>
    </div>
    <div id="numberContainer">
    <div id="topScoreContainer">
        <span>Top</span>
        <br>
        <span id="topScore"></span>
    </div>
    <div id="scoreContainer">
        <span>Score</span>
        <br>
        <span id="score"></span>
    </div>
    <div id="nextPieceContainer">
        <span>Next</span>
        <br>
        <span id="nextPiece"></span>
    </div>
    <div id="levelContainer">
        <span>Level</span>
        <br>
        <span id="level">0</span>
    </div>
</div>
<script>
    // php server url for in javascript
    const scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
    alert(scoreInsertionURL);
</script>

<script src="Tetris.js"></script>
</body>
</html>