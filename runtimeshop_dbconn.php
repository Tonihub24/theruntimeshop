<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$dbUsername = "runtimeshop_admin";
$dbPassword = "YourStrongPassword123!";
$dbName = "runtimeshop_db";


try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbName;charset=utf8mb4", $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Error: Could not connect to the database.");
}
?>
