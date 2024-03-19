const mazeContainer = document.getElementById("maze-container");
const rows = 9;
const cols = 16;
let mazeSolved = false;
let score = 0;

function generateMaze() {
    mazeContainer.innerHTML = '';
    mazeSolved = false;
    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < cols; j++) {
            const cell = document.createElement("div");
            cell.classList.add("cell");
            cell.setAttribute("data-row", i);
            cell.setAttribute("data-col", j);
            if (i === 0 && j === 0) {
                cell.classList.add("start");
            }
            if (i === rows - 1 && j === cols - 1) {
                cell.classList.add("end");
            }
            const isStartEndAdjacent = (i === 0 && j === 0) || (i === rows - 1 && j === cols - 1);
            if (!isStartEndAdjacent && Math.random() < 0.5) {
                cell.classList.add("wall");
            }
            cell.style.top = i * 5 + "vmin";
            cell.style.left = j * 5 + "vmin";
            mazeContainer.appendChild(cell);
        }
    }
    const player = document.createElement("div");
    player.classList.add("cell", "player");
    player.style.top = "0";
    player.style.left = "0";
    mazeContainer.appendChild(player);
    solveMaze();
    initializeFog();
    revealCellsAroundPlayer(0, 0);
}

function solveMaze() {
    const startCell = document.querySelector(".start");
    const endCell = document.querySelector(".end");
    if (startCell && endCell) {
        const startRow = parseInt(startCell.getAttribute("data-row"));
        const startCol = parseInt(startCell.getAttribute("data-col"));
        const endRow = parseInt(endCell.getAttribute("data-row"));
        const endCol = parseInt(endCell.getAttribute("data-col"));
        dfs(startRow, startCol, endRow, endCol);
    }
}

function dfs(currentRow, currentCol, endRow, endCol) {
    if (currentRow < 0 || currentRow >= rows || currentCol < 0 || currentCol >= cols || mazeSolved) {
        return;
    }
    const currentCell = document.querySelector(`.cell[data-row="${currentRow}"][data-col="${currentCol}"]`);
    if (!currentCell || currentCell.classList.contains("wall") || currentCell.classList.contains("visited")) {
        return;
    }
    if (currentRow === endRow && currentCol === endCol) {
        mazeSolved = true;
    }
    currentCell.classList.add("visited");
    dfs(currentRow + 1, currentCol, endRow, endCol);
    dfs(currentRow - 1, currentCol, endRow, endCol);
    dfs(currentRow, currentCol + 1, endRow, endCol);
    dfs(currentRow, currentCol - 1, endRow, endCol);
}

function movePlayer(direction) {
    const player = document.querySelector(".player");
    const playerTop = parseInt(player.style.top) / 5;
    const playerLeft = parseInt(player.style.left) / 5;
    let newTop = playerTop;
    let newLeft = playerLeft;
    switch (direction) {
        case "up":
            newTop = Math.max(0, playerTop - 1);
            break;
        case "down":
            newTop = Math.min(rows - 1, playerTop + 1);
            break;
        case "left":
            newLeft = Math.max(0, playerLeft - 1);
            break;
        case "right":
            newLeft = Math.min(cols - 1, playerLeft + 1);
            break;
    }
    const cell = document.querySelector(`.cell[data-row="${newTop}"][data-col="${newLeft}"]`);
    if (cell && !cell.classList.contains("wall")) {
        player.style.top = newTop * 5 + "vmin";
        player.style.left = newLeft * 5 + "vmin";
    }
    if (newTop === rows - 1 && newLeft === cols - 1) {
        score++;
        document.getElementById("Score").innerHTML = "Maze's solved: " + score;
        generateSolvableMaze(); // Het doolhof opnieuw genereren als het oplosbaar is
    }
    revealCellsAroundPlayer(newTop, newLeft);
}

function generateSolvableMaze() {
    do {
        generateMaze();
    } while (!mazeSolved);
}

generateSolvableMaze();

document.addEventListener("keydown", function (event) {
    switch (event.key) {
        case "ArrowUp":
            movePlayer("up");
            break;
        case "ArrowDown":
            movePlayer("down");
            break;
        case "ArrowLeft":
            movePlayer("left");
            break;
        case "ArrowRight":
            movePlayer("right");
            break;
    }
});

function initializeFog() {
    const cells = document.querySelectorAll('.cell');
    cells.forEach(cell => {
        if (!cell.classList.contains('start') && !cell.classList.contains('end')) {
            cell.classList.add('fog');
        }
    });
}

function revealCellsAroundPlayer(playerTop, playerLeft) {
    for (let i = -0; i <= 0; i++) {
        for (let j = -0; j <= 0; j++) {
            const row = playerTop + i;
            const col = playerLeft + j;
            if (row >= 0 && row < rows && col >= 0 && col < cols) {
                const cell = document.querySelector(`.cell[data-row="${row}"][data-col="${col}"]`);
                if (cell && cell.classList.contains('fog')) {
                    cell.classList.remove('fog');
                }
            }
        }
    }
}