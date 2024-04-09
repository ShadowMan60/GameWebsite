
const canvas = document.getElementById("GameField");
const ctx    = canvas.getContext("2d");

canvas.width = 800;         canvas.height = 500;


let backgroundLayer1 = new Image();
backgroundLayer1.onload = function() {
    ctx.drawImage(backgroundLayer1, 0, 0, canvas.width, canvas.height);
};
backgroundLayer1.src = 'images/apollo.jpeg'; // background image

let backgroundLayer2 = new Image();
backgroundLayer2.onload = function() {
    ctx.drawImage(backgroundLayer2, 0, canvas.height - 50, canvas.width, 50);
};
backgroundLayer2.src = 'images/stone_ground.png'; // under layer image



let animationFrameId;
let score = 0;
let gameOverDisplayed = false;

class Player {
    constructor(px, py, pside, pc, imageSrc) {
        this.x = px;
        this.y = py;
        this.width = pside;
        this.height = pside;
        this.color = pc;
        this.jumpheight = 15; // jump height
        this.image = new Image();
        this.image.onload = () => {
            this.draw();
        };
        this.image.src = imageSrc;

        this.shouldJump = false;
        this.jumpcounter = 0;
        this.isGameOver = false;
    }

    jump() {
        if(this.shouldJump){
            this.jumpcounter++;
            if(this.jumpcounter < 15){
                this.y -= this.jumpheight;
            }else if(this.jumpcounter > 14 && this.jumpcounter < 19){
                this.y += 0;
            }else if(this.jumpcounter < 33){
                this.y += this.jumpheight;
            }
            if(this.jumpcounter >= 32){
                this.jumpcounter = 0;
                this.shouldJump = false;
            }
        }
    }

    draw() {
        ctx.drawImage(this.image, this.x, this.y, this.width, this.height);
        this.jump();
    }
}

class Obstacle {
    constructor(x, y, width, height, speed, imageSrc) {
        this.x = x;
        this.y = y;
        this.width = width;
        this.height = height;
        this.speed = speed;
        this.scored = false;
        this.image = new Image();
        this.image.src = imageSrc;
    }

    move() {
        this.x -= this.speed;
    }

    draw() {
        ctx.drawImage(this.image, this.x, this.y, this.width, this.height);
    }
}

let player = new Player(100, canvas.height - 80, 30, "#08ecd0", "images/cube_monster.png"); // player image
let obstacles = [];

function generateObstacle() {
    const obstacleWidth = 30;
    const obstacleHeight = 30;
    const obstacleSpeed = 5;
    const obstacleY = canvas.height - 80;
    const obstacleImageSrc = "images/spike_monster.png"; // obstacle image
    obstacles.push(new Obstacle(canvas.width, obstacleY, obstacleWidth, obstacleHeight, obstacleSpeed, obstacleImageSrc));
}

function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(backgroundLayer1, 0, 0, canvas.width, canvas.height);
    ctx.drawImage(backgroundLayer2, 0, canvas.height - 50, canvas.width, 50);

    player.draw();

    for (let i = 0; i < obstacles.length; i++) {
        obstacles[i].move();
        obstacles[i].draw();

        if (player.x < obstacles[i].x + obstacles[i].width &&
            player.x + player.width > obstacles[i].x &&
            player.y < obstacles[i].y + obstacles[i].height &&
            player.y + player.height > obstacles[i].y) {
            player.isGameOver = true;
            if (!gameOverDisplayed) {
                showGameOver();
                gameOverDisplayed = true;
            }
            return;
        }

        if (obstacles[i].x + obstacles[i].width < 0) {
            obstacles.splice(i, 1);
            score += 10;
            document.getElementById("score-field").innerHTML = "Score: " + score;
        }
    }

    if (!player.isGameOver) {
        animationFrameId = requestAnimationFrame(animate);
    }
}

animate();


function showGameOver() {
    ctx.fillStyle = "black";
    ctx.font = "30px Arial";
    ctx.textAlign = "center";
    ctx.fillText("", canvas.width / 2, canvas.height / 2);
    document.getElementById("game-over-text").style.display = "block";
    sendScore(score);
}

document.getElementById("retry-button").addEventListener("click", function() {
    resetGame();
});

function resetGame() {
    player = new Player(100, canvas.height - 80, 30, "#08ecd0", "images/cube_monster.png");
    obstacles = [];
    score = 0;
    gameOverDisplayed = false;
    document.getElementById("score-field").innerHTML = "Score: " + score;
    document.getElementById("game-over-text").style.display = "none";
    animate();
}

addEventListener("keydown", e => {
    if (e.code === 'Space') {
        player.shouldJump = true;
    }
});

function sendScore(score) {
    console.log("Sending score to server: " + score);
    let xhr = new XMLHttpRequest();
    xhr.open("POST", scoreInsertionURL, true); // server url out of PHP
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                console.log(xhr.responseText); // server log
            } else {
                console.error('Score insertion failed: ' + xhr.status);
            }
        }
    };
    xhr.send("score=" + score);
}


setInterval(generateObstacle, 600); // obstacle time
