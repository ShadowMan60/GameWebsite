<?php
// Include the Database class
require_once 'Database.php';

// Initialize session
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Retrieve current username from session
$username = $_SESSION['username'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated username and password from the form
    $newUsername = $_POST['new_username'];
    $newPassword = $_POST['new_password'];

    // Create a new Database instance
    $db = new Database("localhost", "gameweb", "root", "root");

    try {
        // Get the PDO connection instance
        $pdo = $db->getConnection();

        // Prepare SQL statement to update username and password in the 'profile' table
        $stmt = $pdo->prepare("UPDATE profile SET username = :newUsername, password = :newPassword WHERE username = :oldUsername");
        // Bind parameters
        $stmt->bindParam(':newUsername', $newUsername);
        $stmt->bindParam(':newPassword', $newPassword);
        $stmt->bindParam(':oldUsername', $username);
        // Execute the query
        $stmt->execute();

        // Update the session with the new username if it was changed
        $_SESSION['username'] = $newUsername;

        // Redirect with success message
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        echo "Update failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile management</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
<div class="container registration-container">
    <img src="../PHP/GameImg/Logo.png" alt="Logo" class="logo">
    <div class="form-container">
        <h2>profile management</h2>
    <form method="POST" action="">
        <label for="new_username">New Username:</label><br>
        <input type="text" id="new_username" name="new_username" required><br><br>
        <label for="new_password">New Password:</label><br>
        <input type="password" id="new_password" name="new_password" required><br><br>
        <input type="submit" value="Update Account">
    </form>
    </div>
    <div class="link-container">
        <p><a href="index.php">Back to Home</a></p>
    </div>
</div>
<div class="footer">
    <p>© 2024 The Gaming Palace | Kevin | Neo | Jiwoo </p>
</div>

</body>
</html>
