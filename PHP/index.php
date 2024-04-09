<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.PHP");
    exit();
}
$username = $_SESSION['username'];


include_once("database.php");


$db = new Database("localhost", "gameweb", "root", "root");

// Check if the connection was successful
if (!$db->getConnection()) {
    die("Connection failed: " . $db->getConnection()->getMessage());
}

$query = "SELECT username, score FROM highscores ORDER BY score DESC LIMIT 5";

try {
    // Execute the query
    $result = $db->getConnection()->query($query);


    if ($result->rowCount() > 0) {
        $highScores = array();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $highScores[] = $row;
        }
    } else {
        $highScores = array();
    }
} catch (PDOException $e) {
    echo "Error executing query: " . $e->getMessage();
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
        <li></li>

        <li class="search"><div class="container">
            <input type="text" id="searchInput" placeholder="Search...">
            <ul id="resultsList">
                <li><a href="../cubper/cubper.php">Cubper</a></li>
                <li><a href="../mazer/mazer.html">Mazer</a></li>
                <li><a href="../tetris/tetris.html">Tetris</a></li>
            </ul>
        </div></li>

        <li>Hello <?php echo $username; ?></li>

        <li><a href="logout.php">Logout</a></li>
</nav>

<div class="SlideShow">
    <div class="mySlides fade">
        <img src="GameImg/temporary.jpg">
        <a href="../cubper/cubper.php">PLAY CUBPER</a>
    </div>

    <div class="mySlides fade">
        <img src="GameImg/Mazer_logo.png">
        <a href="../mazer/mazer.html">PLAY MAZER</a>
    </div>

    <div class="mySlides fade">
        <img src="GameImg/temporary.jpg">
        <a href="../tetris/tetris.html">PLAY TETRIS</a>
    </div>

    <a class="prev" onclick="plusSlides(-1)">❮</a>
    <a class="next" onclick="plusSlides(1)">❯</a>
</div>

<?php

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
?>

<script src="script.js"></script>
</body>
</html>