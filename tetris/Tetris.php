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
        $stmt = $conn->prepare("INSERT INTO tetris_scores (username, score) VALUES (:username, :score)");
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
    <link rel="stylesheet" href="tetris.css">
</head>
<body>

<nav class="navigation">
    <li class="home"><a href="../PHP/index.php"><img src="Images/Logo.png" alt=""></a></li>
    
    <li></li>
    <li class="container">
    <button onclick="Dropdown()" class="dropbtn">Games <span class="arrow">&#9660;</span></button>
        <div id="myDropdown" class="dropdown-content">
            <a href="../cubper/cubper.php">Cubper</a>
            <a href="../mazer/mazer.php">Mazer</a>
            <a href="../tetris/Tetris.php">Tetris</a>
        </div>
    </li>
    </li>
    <li><a href="../PHP/profileManagement.php">Welcome <?php echo $username; ?></a></li>
    <li><a href="../PHP/logout.php">Logout</a></li>
</nav>
    
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
<div id="Description">
    <H3>Game Description</H3>
    <p>
        Score as many points as possible before you topout by using these "tetrominos" to your advantage!
        Use the ASD for movement or if you want to make it so the tetrominos goes down faster and QE for the rotations.
    </p>
</div>
<script>
    // php server url for in javascript
    const scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";

</script>

<script src="tetris.js"></script>
<script src="/PHP/script.js"></script>
</body>
</html>