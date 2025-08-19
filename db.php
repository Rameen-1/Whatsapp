<?php
$host = 'localhost';
$dbname = 'dbyhv3dnycsqb4';
$username = 'ux7oqwxcx8vsf';
$password = 'v3hxvatbehaf';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
 
