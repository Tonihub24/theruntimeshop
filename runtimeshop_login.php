<?php
session_start();
require_once '/var/www/html/runtimeshop_dbconn.php'; // Ensure this path is correct
global $pdo;
// Log session start
error_log("== LOGIN SCRIPT REACHED ==");

error_log("Session started at: " . date('Y-m-d H:i:s'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Log POST request received
    error_log("POST request received at: " . date('Y-m-d H:i:s'));
    
    // Check for missing fields
    if (empty($_POST['username']) || empty($_POST['pwd'])) {
        error_log("Missing fields in login form. Redirecting to index.php.");
        header("Location: /index.php?error=missingfields"); // Update path to root
        exit();
    }

    // Sanitize inputs
    $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
    $password = $_POST['pwd'];

    // Log sanitized username
    error_log("Sanitized username: " . $username);

    try {
        // Ensure the database connection is established before proceeding
        if (!isset($pdo)) {
            error_log("Database connection not established. Redirecting to index.php.");
            header("Location: /index.php?error=servererror"); // Update path to root
            exit();
        }

        // Prepare and execute SQL query
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();

        // Log user fetch result
        error_log("User fetch result: " . print_r($user, true));

        // Verify password and log the user in
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Log successful login
            error_log("Logged in user: " . $_SESSION['username'] . " (User ID: " . $_SESSION['user_id'] . ")");
            
            // Redirect to the dashboard
            header("Location: /dashboard.php"); // Update path to root
            exit();
        } else {
            error_log("Login failed for username: " . $username);
            header("Location: /index.php?error=wrongpassword"); // Update path to root
            exit();
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        header("Location: /index.php?error=servererror"); // Update path to root
        exit();
    }
} else {
    error_log("Invalid request method. Redirecting to index.html.");
    header("Location: /index.php"); // Update path to root
    exit();
}
?>
