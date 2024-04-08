<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        * {box-sizing: border-box}
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
        }
        a{
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: black;
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
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.PHP");
    exit();
}
$username = $_SESSION['username'];
?>
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
