<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.PHP");
    exit();
}
$username = $_SESSION['username'];

include_once("database.php");

$db = new Database("localhost", "gameweb", "root", "root");

if (!$db->getConnection()) {
    die("Connection failed: " . $db->getConnection()->getMessage());
}

$query_cubper = "SELECT username, score FROM cubper_scores ORDER BY score DESC LIMIT 5";
$query_tetris = "SELECT username, score FROM tetris_scores ORDER BY score DESC LIMIT 5";
$query_mazer = "SELECT username, score FROM mazer_scores ORDER BY score DESC LIMIT 5";

try {

    $result_cubper = $db->getConnection()->query($query_cubper);
    $result_tetris = $db->getConnection()->query($query_tetris);
    $result_mazer = $db->getConnection()->query($query_mazer);

    if ($result_cubper->rowCount() > 0) {
        $highScores_cubper = array();
        while ($row = $result_cubper->fetch(PDO::FETCH_ASSOC)) {
            $highScores_cubper[] = $row;
        }
    } else {
        $highScores_cubper = array();
    }

    if ($result_tetris->rowCount() > 0) {
        $highScores_tetris = array();
        while ($row = $result_tetris->fetch(PDO::FETCH_ASSOC)) {
            $highScores_tetris[] = $row;
        }
    } else {
        $highScores_tetris = array();
    }

    if ($result_mazer->rowCount() > 0) {
        $highScores_mazer = array();
        while ($row = $result_mazer->fetch(PDO::FETCH_ASSOC)) {
            $highScores_mazer[] = $row;
        }
    } else {
        $highScores_mazer = array();
    }
} catch (PDOException $e) {
    echo "Error executing query: " . $e->getMessage();
}
function displayHighScores($game, $highScores) {
    echo "<h2>$game High Scores</h2>";
    if (!empty($highScores)) {
        echo "<table>";
        echo "<tr><th>Rank</th><th>Username</th><th>Score</th></tr>";
        foreach ($highScores as $rank => $score) {
            echo "<tr>";
            echo "<td>" . ($rank + 1) . "</td>";
            echo "<td>" . $score['username'] . "</td>";
            echo "<td>" . $score['score'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No high scores available";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navigation">
    <li class="home"><a href="index.php">Homepage</a></li>
    <li class="search">
        <div class="container">
            <input type="text" id="searchInput" placeholder="Search...">
            <ul id="resultsList">
                <li><a href="../cubper/cubper.php">Cubper</a></li>
                <li><a href="../mazer/mazer.php">Mazer</a></li>
                <li><a href="../tetris/tetris.php">Tetris</a></li>
            </ul>
        </div>
    </li>
    <li>Hello <?php echo $username; ?></li>
    <li><a href="logout.php">Logout</a></li>
</nav>

<div class="SlideShow">
    <div class="mySlides fade">
        <img src="GameImg/Cubper_logo.png">
        <a href="../cubper/cubper.php">PLAY CUBPER</a>
    </div>

    <div class="mySlides fade">
        <img src="GameImg/Mazer_logo.png">
        <a href="../mazer/mazer.php">PLAY MAZER</a>
    </div>

    <div class="mySlides fade">
        <img src="GameImg/Tetris_logo.jpg">
        <a href="../tetris/tetris.php">PLAY TETRIS</a>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
</div>

<div class="ScoresContainer">
    <div><?php displayHighScores("Cubper", $highScores_cubper); ?></div>
    <div><?php displayHighScores("Tetris", $highScores_tetris); ?></div>
    <div><?php displayHighScores("Mazer", $highScores_mazer); ?></div>
</div>

<script src="script.js"></script>
</body>
</html>


