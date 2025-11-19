<?php
session_start();
require_once '/var/www/html/runtimeshop_dbconn.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Prevent direct access
if (!isset($_POST['signup-submit'])) {
    header("Location: https://theruntimeshop.com/index.php");
    exit();
}

// Retrieve and sanitize form inputs
$username = trim($_POST['username']);
$password = trim($_POST['pwd']);
$email = trim($_POST['email']);
$membership = trim($_POST['membership']);
$profileType = trim($_POST['profileType']);


// Validate input fields
if (empty($username) || empty($password) || empty($email) || empty($membership)) {
    header("Location: https://theruntimeshop.com/index.php?error=missingfields");
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: https://theruntimeshop.com/index.php?error=invalidemail");
    exit();
}
if ($membership !== 'regular' && $membership !== 'pro') {
    header("Location: https://theruntimeshop.com/index.php?error=invalidmembership");
    exit();
}
if (empty($profileType) || !in_array($profileType, ['frontend', 'stacklearner', 'fullstacker'])) {
    header("Location: https://theruntimeshop.com/index.php?error=invalidprofile");
    exit();
}


try {
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        header("Location: https://theruntimeshop.com/index.php?error=userexists");
        exit();
    }

    // Hash password and insert new user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, membership) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword, $membership]);

    $user_id = $pdo->lastInsertId();

    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;
    $_SESSION['membership'] = $membership;

    // Redirect to PayPal for pro membership
    if ($membership === 'pro') {
        $paypalURL = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=kione2001sylviast@gmail.com"
            . "&item_name=Runtime+Shop+Pro+Membership"
            . "&amount=10.00"
            . "&currency_code=USD"
            . "&return=https://theruntimeshop.com/signup_success.php"
            . "&notify_url=https://theruntimeshop.com/ipn_listener.php"
            . "&custom=" . urlencode($user_id);
        header("Location: $paypalURL");
        exit();
    } else {
        // Regular membership goes directly to success page
        header("Location: https://theruntimeshop.com/signup_success.php");
        exit();
    }

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    header("Location: https://theruntimeshop.com/index.php?error=dberror");
    exit();
}
?>
