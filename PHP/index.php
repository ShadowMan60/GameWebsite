<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.PHP");
    exit();
}
$username = $_SESSION['username'];
?>

<nav class="navigation">
    <ul>
        <li>Hello <?php echo $username; ?></li>
        <li><a href="index.php">Homepage</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</nav>

<div class="text">
    <h2>Welcome, <?php echo $username; ?>!</h2>
    <p>Hello, <?php echo $username; ?>. Welcome to our website.</p>
    <p><a href="logout.php">Logout</a></p>
</div>

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

<script src="script.js"></script>
</body>
</html>
