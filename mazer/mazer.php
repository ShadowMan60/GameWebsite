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
        $stmt = $conn->prepare("INSERT INTO mazer_scores (username, score) VALUES (:username, :score)");
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
    <link rel="stylesheet" href="mazer.css">
    <title>Mazer</title>
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

    <p id="Score">Maze's solved: 0</p>
    <p id="Time">0:30 left</p>
    <div id="GameOver">Game Over<button onclick="reset()">Restart</button></div>
    <div id="maze-container"></div>

    <div id="Description">
        <H3>Game Description</H3>
        <p>In Mazer you will have to complete as many maze's as possible in 30 seconds, with each solve you will gain 5 seconds. Use the WASD to move arround, There is also 1 special item you can find called the Expander that will reveal the maze in a 7 by 7 radius around the players position.
        </p>
    </div>
    
</body>
<script>
    // php server url for in javascript
    let scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
</script>

<script src="mazer.js"></script>
<script src="/PHP/script.js"></script>
</html>