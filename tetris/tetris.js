const canvas = document.getElementById("board");
const context = canvas.getContext("2d");
const gameOverElement = document.getElementById("gameOverContainer");
context.scale(20, 20);
let linesCount = 0;
let level = 0; // Initialize level
let nextPieceType = '';
let animationId;
let dropCounter = 0;
let dropInterval = 1000;
let lastTime = 0;
let highestScore = localStorage.getItem("topScore") || 0;
let gameActive = true;
const colors = [
    null,
    "#FF0D72",
    "#0DC2FF",
    "#0DFF72",
    "#F538FF",
    "#FF8E0D",
    "#FFE138",
    "#3877FF"
];
const arena = createArray(11, 21);
const player = {
    position: {x : 0, y : 0},
    array: null,
    score: 0
};


function game() {
    // Reset gameOver state
    gameActive = true;

    // Reset lines count and level
    linesCount = 0;
    level = 0;
    document.getElementById("lines").innerText = linesCount;
    document.getElementById("level").innerText = level; // Display level

    dropInterval = 1000;

    player.score = 0;

    // Reset player
    playerReset();
    updateScore();
    
    gameOverElement.style.display = "none";

    // Start a new game loop
    animationId = requestAnimationFrame(update);
}

function draw() {
    // Clear the canvas
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Draw the board background
    context.fillStyle = '#000';
    context.fillRect(0, 0, canvas.width, canvas.height);

    // Draw grid lines
    context.strokeStyle = '#888'; // Grid color
    context.lineWidth = 0.05; // Grid line width
    for (let x = 0; x <= canvas.width; x += 1) {
        context.beginPath();
        context.moveTo(x, 0);
        context.lineTo(x, canvas.height);
        context.stroke();
    }
    for (let y = 0; y <= canvas.height; y += 1) {
        context.beginPath();
        context.moveTo(0, y);
        context.lineTo(canvas.width, y);
        context.stroke();
    }

    // Draw the game pieces
    drawArray(arena, { x: 0, y: 0 });
    drawArray(player.array, player.position);
}

function drawArray(array, offset) {
    array.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value !== 0) {
                context.fillStyle = colors[value];
                context.fillRect(x + offset.x, y + offset.y, 1, 1);
            }
        });
    });
}

function merge(arena, player) {
    player.array.forEach((row, y) => {
        row.forEach((value, x) => {
            if (value !== 0) {
                arena[y + player.position.y][x + player.position.x] = value;
            }
        });
    });
}

function createArray(w, h) {
    const array = [];
    while (h--) {
        array.push(new Array(w).fill(0));
    }
    return array;
}

function createPiece(type) {
    // If nextPieceType is empty, generate a random next piece
    if (!nextPieceType) {
        nextPieceType = 'ILJOTSZ'[Math.floor(Math.random() * 7)];
    }

    // Set the current piece to the next piece type
    type = nextPieceType;
    
    // Generate a new random next piece type
    nextPieceType = 'ILJOTSZ'[Math.floor(Math.random() * 7)];

    // Update the display of the next piece in the HTML
    document.getElementById("nextPiece").innerText = nextPieceType;

    // Create the piece matrix based on the type
    if (type === 'T') {
        return [
            [0, 0, 0],
            [1, 1, 1],
            [0, 1, 0],
        ];
    } else if (type === 'O') {
        return [
            [2, 2],
            [2, 2],
        ];
    } else if (type === 'L') {
        return [
            [0, 3, 0],
            [0, 3, 0],
            [0, 3, 3],
        ];
    } else if (type === 'J') {
        return [
            [0, 4, 0],
            [0, 4, 0],
            [4, 4, 0],
        ];
    } else if (type === 'I') {
        return [
            [0, 0, 5, 0],
            [0, 0, 5, 0],
            [0, 0, 5, 0],
            [0, 0, 5, 0],
        ];
    } else if (type === 'S') {
        return [
            [0, 6, 6],
            [6, 6, 0],
            [0, 0, 0],
        ];
    } else if (type === 'Z') {
        return [
            [7, 7, 0],
            [0, 7, 7],
            [0, 0, 0],
        ];
    }
}

function pieceDrop() {
    if (gameActive) {
        player.position.y++;
        if (collide(arena, player)) {
            player.position.y--;
            merge(arena, player);
            playerReset();
            arenaSweep();
            updateScore();
        }
        dropCounter = 0;
    }
}

function playerMove(direction) {
    player.position.x += direction;
    if (collide(arena, player)) {
        player.position.x -= direction;
    }
}

function collide(arena, player) {
    const a = player.array;
    const p = player.position;
    for (let y = 0; y < a.length; ++y) {
        for (let x = 0; x < a[y].length; ++x) {
            if (a[y][x] !== 0 &&
                (arena[y + p.y] &&
                    arena[y + p.y][x + p.x]) !== 0) {
                return true;
            }
        }
    }
    return false;
}

function playerRotate(direction) {
    const position = player.position.x;
    let offset = 1;
    rotate(player.array, direction);
    while (collide(arena, player)) {
        player.position.x += offset;
        offset = -(offset + (offset > 0 ? 1 : -1));
        if (offset > player.array[0].length) {
            rotate(player.array, -dir);
            player.position.x = position;
            return;
        }
    }
}

function rotate(array, direction) {
    for (let y = 0; y < array.length; ++y) {
        for (let x = 0; x < y; ++x) {
            [
                array[x][y],
                array[y][x],
            ] = [
                array[y][x],
                array[x][y],
            ];
        }
    }
    if (direction > 0) {
        array.forEach(row => row.reverse());
    } else {
        array.reverse();
    }
}

function arenaSweep() {
    let rowCount = 0;
    outer: for (let y = arena.length - 1; y > 0; --y) {
        for (let x = 0; x < arena[y].length; ++x) {
            if (arena[y][x] === 0) {
                continue outer;
            }
        }
        const row = arena.splice(y, 1)[0].fill(0);
        arena.unshift(row);
        ++y;

        player.score += (rowCount + 1) * 10;
        rowCount *= 2;
        
        // Update lines count
        linesCount += 1;
        document.getElementById("lines").innerText = linesCount;

        // Check if it's time to increase the level
        if (linesCount >= 10 && linesCount % 10 === 0) {
            level++; // Increase level
            dropInterval *= 0.9; // Decrease drop interval to increase speed
            document.getElementById("level").innerText = level; // Update level display
        }
    }
}

function update(time = 0) {
    const deltaTime = time - lastTime;
    lastTime = time;

    dropCounter += deltaTime;
    if (dropCounter > dropInterval) {
        pieceDrop();
    }

    draw();
    updateScore(); // Update score after drawing
    animationId = requestAnimationFrame(update); // Store animation ID
}


function updateScore() {
    const scoreElement = document.getElementById("score");
    const currentScore = player.score;
    scoreElement.innerText = currentScore;

    // Check if the current score is higher than the highest score
    if (currentScore > highestScore) {
        highestScore = currentScore;
        // Save the highest score to local storage
        localStorage.setItem("topScore", highestScore);
    }

    // Update highest score on the page
    const highestScoreElement = document.getElementById("topScore");
    highestScoreElement.innerText = highestScore;
}

function playerReset() {
    const pieces = 'ILJOTSZ';
    player.array = createPiece(pieces[pieces.length * Math.random() | 0]);
    player.position.y = 0;
    player.position.x = (arena[0].length / 2 | 0) - (player.array[0].length / 2 | 0);
    if (collide(arena, player)) {
        // Game over condition
        // Clear the arena and reset score
        gameActive = false;
        arena.forEach(row => row.fill(0));
        player.score = player.score;
        
        // Check if the current score is higher than the highest score
        if (player.score > highestScore) {
            highestScore = player.score;
            localStorage.setItem("topScore", highestScore);
        }
        
        // Update highest score on the page
        const highestScoreElement = document.getElementById("topScore");
        highestScoreElement.innerText = highestScore;

        gameOverElement.style.display = 'block';

        document.getElementById('restartButton').addEventListener('click', game);

        sendScore(player.score);
        
        // Stop the game loop
        cancelAnimationFrame(animationId);
        return;
    }
}

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

document.addEventListener('keydown', event => {
    if (event.keyCode === 65) {
        playerMove(-1);
    } else if (event.keyCode === 68) {
        playerMove(1);
    } else if (event.keyCode === 83) {
        pieceDrop();
    } else if (event.keyCode === 81) {
        playerRotate(-1);
    } else if (event.keyCode === 69) {
        playerRotate(1);
    }
});

playerReset();
updateScore();
update();