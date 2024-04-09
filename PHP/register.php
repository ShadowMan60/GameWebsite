<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
</head>
<body>
<h2>User Registration</h2>
<form method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>
<p>Already have an account? <a href="login.php">Login</a></p>

<?php

require_once 'Database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];


    $db = new Database("localhost", "gameweb", "root", "root");

    try {

        $pdo = $db->getConnection();

        $stmt = $pdo->prepare("INSERT INTO profile (username, password) VALUES (:username, :password)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        echo "<p>User registered successfully!</p>";
    } catch (PDOException $e) {
        echo "Registration failed: " . $e->getMessage();
    }
}
?>

</body>
</html>
