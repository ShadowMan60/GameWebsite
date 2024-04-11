<?php
session_start();

require_once 'Database.php';

class Registration {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registerUser($username, $password) {
        try {
            $pdo = $this->db->getConnection();
            $stmt = $pdo->prepare("INSERT INTO profile (username, password) VALUES (:username, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Registration failed: " . $e->getMessage();
            return false;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $db = new Database("localhost", "gameweb", "root", "root");


    $registration = new Registration($db);

    if ($registration->registerUser($username, $password)) {

    } else {

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
<div class="container registration-container">
    <img src="../PHP/GameImg/Logo.png" alt="Logo" class="logo">
    <div class="form-container">
        <h2>User Registration</h2>
        <form method="POST" action="">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Register">
        </form>
    </div>
    <div class="link-container">
        <p>already have an account? <a href="login.php">Log In</a></p>
    </div>
</div>
<div class="footer">
    <p>© 2024 The Gaming Palace | Kevin | Neo | Jiwoo </p>
</div>
</body>
</html>
