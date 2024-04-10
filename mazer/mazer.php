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
    <link rel="stylesheet" href="mazer.css">
    <title>Mazer</title>
</head>
<body>
    <p id="Score">Maze's solved: 0</p>
    <p id="Time">0:30 left</p>
    <div id="GameOver">Game Over<button onclick="reset()">Restart</button></div>
    <div id="maze-container"></div>
    
</body>
<script src="mazer.js"></script>
<script>
    // php server url for in javascript
    // let scoreInsertionURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
</script>
</html>