<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include '../db.php';
 
$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['receiver_id'] ?? null;
 
if ($receiver_id) {
    $stmt = $pdo->prepare("SELECT * FROM messages 
        WHERE (sender_id = ? AND receiver_id = ?) 
           OR (sender_id = ? AND receiver_id = ?)
        ORDER BY timestamp ASC");
    $stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);
 
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($messages);
}
 
