<?php
// Include the Database class
require_once 'Database.php';

// Initialize session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Create a new Database instance
    $db = new Database("localhost", "gameweb", "root", "root");

    try {
        // Get the PDO connection instance
        $pdo = $db->getConnection();
        // Prepare SQL statement to select user from the 'profile' table
        $stmt = $pdo->prepare("SELECT * FROM profile WHERE username = :username AND password = :password");
        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        // Execute the query
        $stmt->execute();
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists
        if ($user) {
            // Store username in session
            $_SESSION['username'] = $username;
            // Redirect to index.PHP
            header("Location: index.PHP");
            exit(); // Make sure no further code is executed
        } else {
            // Redirect back to login page with error message
            header("Location: login.PHP?error=1");
            exit();
        }
    } catch (PDOException $e) {
        echo "Login failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
</head>
<body>
<h2>User Login</h2>
<form method="POST" action="">
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
<p>Don't have an account? <a href="register.php">Register</a></p>
<?php

if (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "<p>Invalid username or password. Please try again.</p>";
}
?>

</body>
</html>
