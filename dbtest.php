<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "127.0.0.1";
$username   = "runtimeshop_admin";
$password   = "YourStrongPassword123!";  // replace with your real password
$database   = "runtimeshop_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully to the database!";
?>
