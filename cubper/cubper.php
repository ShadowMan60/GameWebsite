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


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>test</title>
    <link rel="stylesheet" href="cubper.css">
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

<canvas id="GameField"></canvas>
<p id="score-field">Score: 0</p>
<div id="game-over-text" style="display: none;">
    You Failed<br>
    <button id="retry-button">Retry</button>
</div>

<div id="Description">
    <H3>cubper Description</H3>
    <p>cubper is the best game for people with no live like you.</p>
</div>

<script>
    // php server url for in javascript
    let scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
</script>

<script src="cubper.js"></script>
<script src="/PHP/script.js"></script>
</body>
</html>