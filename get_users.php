<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
include '../db.php';
 
$current_user_id = $_SESSION['user_id'];
 
$stmt = $pdo->prepare("SELECT id, username FROM users WHERE id != ?");
$stmt->execute([$current_user_id]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
echo json_encode($users);
 
