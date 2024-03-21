document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('tetris');
    const context = canvas.getContext('2d');

    context.scale(20, 20);

    let linesCount = 0; // Initialize lines count

    function arenaSweep() {
        let rowCount = 1;
        outer: for (let y = arena.length - 1; y > 0; --y) {
            for (let x = 0; x < arena[y].length; ++x) {
                if (arena[y][x] === 0) {
                    continue outer;
                }
            }
            const row = arena.splice(y, 1)[0].fill(0);
            arena.unshift(row);
            ++y;

            player.score += rowCount * 10;
            rowCount *= 2;
            // Burn one line and update the lines count
            linesCount += 1;
            document.getElementById('lines').innerText = "Lines:" + linesCount;
        }
    }

    function collide(arena, player) {
        const m = player.matrix;
        const o = player.pos;
        for (let y = 0; y < m.length; ++y) {
            for (let x = 0; x < m[y].length; ++x) {
                if (m[y][x] !== 0 &&
                    (arena[y + o.y] &&
                        arena[y + o.y][x + o.x]) !== 0) {
                    return true;
                }
            }
        }
        return false;
    }

    function createMatrix(w, h) {
        const matrix = [];
        while (h--) {
            matrix.push(new Array(w).fill(0));
        }
        return matrix;
    }

    // Inside the createPiece function, add the nextPieceType variable
let nextPieceType = '';

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
    document.getElementById('next-piece').innerText = `Next Piece: ${nextPieceType}`;

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

    function draw() {
        context.fillStyle = '#000';
        context.fillRect(0, 0, canvas.width, canvas.height);

        drawMatrix(arena, { x: 0, y: 0 });
        drawMatrix(player.matrix, player.pos);
    }

    function drawMatrix(matrix, offset) {
        matrix.forEach((row, y) => {
            row.forEach((value, x) => {
                if (value !== 0) {
                    context.fillStyle = colors[value];
                    context.fillRect(x + offset.x,
                        y + offset.y,
                        1, 1);
                }
            });
        });
    }

    function merge(arena, player) {
        player.matrix.forEach((row, y) => {
            row.forEach((value, x) => {
                if (value !== 0) {
                    arena[y + player.pos.y][x + player.pos.x] = value;
                }
            });
        });
    }

    // Define the playerDrop function
function playerDrop() {
    if (gameActive) {
        player.pos.y++;
        if (collide(arena, player)) {
            player.pos.y--;
            merge(arena, player);
            playerReset();
            arenaSweep();
            updateScore();
        }
        dropCounter = 0;
    }
}

    function playerMove(dir) {
        player.pos.x += dir;
        if (collide(arena, player)) {
            player.pos.x -= dir;
        }
    }

    function playerReset() {
        const pieces = 'ILJOTSZ';
        player.matrix = createPiece(pieces[pieces.length * Math.random() | 0]);
        player.pos.y = 0;
        player.pos.x = (arena[0].length / 2 | 0) - (player.matrix[0].length / 2 | 0);
        if (collide(arena, player)) {
            // Game over condition
            // Clear the arena and reset score
            gameActive = false;
            arena.forEach(row => row.fill(0));
            player.score = 0;
            
            // Check if the current score is higher than the highest score
            if (player.score > highestScore) {
                highestScore = player.score;
                localStorage.setItem('highestScore', highestScore);
            }
            
            // Update highest score on the page
            const highestScoreElement = document.getElementById('highestScore');
            highestScoreElement.innerText = highestScore;
            
            // Show game over message
            const gameOverElement = document.getElementById('gameOver');
            gameOverElement.style.display = 'block';
            
            // Stop the game loop
            cancelAnimationFrame(animationId);
            return;
        }
    }

    let animationId;

    function playerRotate(dir) {
        const pos = player.pos.x;
        let offset = 1;
        rotate(player.matrix, dir);
        while (collide(arena, player)) {
            player.pos.x += offset;
            offset = -(offset + (offset > 0 ? 1 : -1));
            if (offset > player.matrix[0].length) {
                rotate(player.matrix, -dir);
                player.pos.x = pos;
                return;
            }
        }
    }

    function rotate(matrix, dir) {
        for (let y = 0; y < matrix.length; ++y) {
            for (let x = 0; x < y; ++x) {
                [
                    matrix[x][y],
                    matrix[y][x],
                ] = [
                    matrix[y][x],
                    matrix[x][y],
                ];
            }
        }
        if (dir > 0) {
            matrix.forEach(row => row.reverse());
        } else {
            matrix.reverse();
        }
    }

    let dropCounter = 0;
    let dropInterval = 1000;

    let lastTime = 0;

    function update(time = 0) {
        const deltaTime = time - lastTime;
        lastTime = time;
    
        dropCounter += deltaTime;
        if (dropCounter > dropInterval) {
            playerDrop();
        }
    
        draw();
        updateScore(); // Update score after drawing
        animationId = requestAnimationFrame(update); // Store animation ID
    }

    let highestScore = localStorage.getItem('highestScore') || 0; // Retrieve highest score from localStorage or set it to 0 if not found

    function updateScore() {
        const scoreElement = document.getElementById('score');
        const currentScore = player.score;
        scoreElement.innerText = "score: " + currentScore;
    
        // Check if the current score is higher than the highest score
        if (currentScore > highestScore) {
            highestScore = currentScore;
            // Save the highest score to local storage
            localStorage.setItem('highestScore', highestScore);
        }
    
        // Update highest score on the page
        const highestScoreElement = document.getElementById('highestScore');
        highestScoreElement.innerText = highestScore;
    }
 
let gameActive = true; // Global variable to track the game state

// Define the update function to control the game loop
function update(time = 0) {
    if (gameActive) {
        const deltaTime = time - lastTime;
        lastTime = time;

        dropCounter += deltaTime;
        if (dropCounter > dropInterval) {
            playerDrop();
        }

        draw();
        updateScore(); // Update score after drawing
        animationId = requestAnimationFrame(update);
    }
}

// Define the restartGame function
function restartGame() {
    // Reset gameOver state
    gameActive = true;

    // Reset lines count
    linesCount = 0;
    document.getElementById('lines').innerText = "Lines: " + linesCount;

    // Hide the game over message
    const gameOverElement = document.getElementById('gameOver');
    gameOverElement.style.display = 'none';

    // Reset player
    playerReset();
    updateScore();

    // Start a new game loop
    animationId = requestAnimationFrame(update);
}

// Add an event listener to the restart button
document.getElementById('restartButton').addEventListener('click', restartGame);

    
    const colors = [
        null,
        '#FF0D72',
        '#0DC2FF',
        '#0DFF72',
        '#F538FF',
        '#FF8E0D',
        '#FFE138',
        '#3877FF',
    ];

    const arena = createMatrix(12, 20);

    const player = {
        pos: { x: 0, y: 0 },
        matrix: null,
        score: 0,
    };

    document.addEventListener('keydown', event => {
        if (event.keyCode === 37) {
            playerMove(-1);
        } else if (event.keyCode === 39) {
            playerMove(1);
        } else if (event.keyCode === 40) {
            playerDrop();
        } else if (event.keyCode === 81) {
            playerRotate(-1);
        } else if (event.keyCode === 87) {
            playerRotate(1);
        }
    });

    playerReset();
    updateScore();
    update();
});