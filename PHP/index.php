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
    <style>
        * {
            box-sizing: border-box
        }

        .mySlides {
            display: none;
            background-color: rgb(130, 130, 130);
        }

        img {
            vertical-align: middle;
            width: 100%;
            height: 200px;
            background-size:contain;
        }

        body{
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 25px;
            height: 100vh;
            position: relative;
            flex-direction: column;
        }

        a{
            margin: 0;
            justify-content: center;
            text-decoration: none;
            color: black;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .SlideShow {
            height: 220px;
        }

        .prev, .next {
            cursor: pointer;
            position: relative;
            width: 50px;
            height:220px;
            padding: 100px 16px;
            color: white;
            background-color: rgb(130, 130, 130);
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            user-select: none;
        }

        .next {
            border-radius: 0 5px 5px 0;
            top:-440px;
            left:375px;
        }

        .prev {
            border-radius: 5px 0 0 5px;
            top:-220px;
            left:-50px;
        }

        .prev:hover, .next:hover {
            background-color: rgb(90, 90, 90);
        }

        .text {
            color: black;
            font-size: 15px;
            padding: 8px 12px;
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .navigation{
            position: absolute;
            right: 4px;
            top: 1px;
        }

        .navigation ul{
            display: flex;
            font-size: 22px;
            gap: 20px;
            list-style: none;
        }

        .navigation li:hover{
            background-color: green;
        }

        .fade {
            animation-name: fade;
            animation-duration: 1.5s;
        }

        @keyframes fade {
            from {opacity: .4}
            to {opacity: 1}
        }

        @media only screen and (max-width: 300px) {
            .prev, .next,.text {font-size: 11px}
        }

    </style>
</head>
<body>
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


<script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("mySlides");
        let dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";
        dots[slideIndex-1].className += " active";
    }
</script>
</body>
</html>
