<?php
session_start();
include 'db.php';

// Check user login
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header("Location: index.php");
    exit;
}

$uid = $_SESSION['user']['id'];

// Prevent duplicate subscription requests
$check = $conn->query("SELECT * FROM subscriptions WHERE user_id=$uid");
if ($check->num_rows == 0) {
    $insert = $conn->query("INSERT INTO subscriptions (user_id) VALUES ($uid)");
    if (!$insert) {
        die("Database error: " . $conn->error);
    }
}

// Redirect back to dashboard
header("Location: user_dashboard.php");
exit;
