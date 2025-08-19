<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include '../db.php';
 
$sender_id = $_SESSION['user_id'];
$receiver_id = $_POST['receiver_id'] ?? null;
$message = $_POST['message'] ?? '';
 
if ($receiver_id && $message) {
    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $message]);
}
 
