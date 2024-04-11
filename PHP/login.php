<?php
session_start();

require_once 'Database.php';

class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function login($username, $password) {
        try {
            $pdo = $this->db->getConnection();
            $stmt = $pdo->prepare("SELECT * FROM profile WHERE username = :username AND password = :password");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['username'] = $username;
                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php?error=1");
                exit();
            }
        } catch (PDOException $e) {
            echo "Login failed: " . $e->getMessage();
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $db = new Database("localhost", "gameweb", "root", "root");


    $user = new User($db);


    $user->login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
<div class="container login-container">
    <img src="../PHP/GameImg/Logo.png" alt="Logo" class="logo">
    <div class="form-container">
        <h2>Sign In</h2>
        <form method="POST" action="">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p class='error-message'>Invalid username or password. Please try again.</p>";
        }
        ?>
    </div>
    <div class="link-container">
        <p>Not a member? <a href="register.php">Create a new account</a></p>
    </div>
</div>
<div class="footer">
    <p>© 2024 The Gaming Palace | Kevin | Neo | Jiwoo </p>
</div>
</body>
</html>
