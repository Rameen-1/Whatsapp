<?php
session_start(); // ✅ Required to use $_SESSION
 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// Database connection
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
 
// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $passwordInput = $_POST['password'] ?? '';
 
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
 
    if ($user && password_verify($passwordInput, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: chat.php");
        exit();
    } else {
        $error = "Invalid email or password";
    }
}
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Login - WhatsApp Clone</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <?php if (!empty($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</body>
</html>
 
 
