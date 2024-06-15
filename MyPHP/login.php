<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $login_error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .auth-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            text-align: center;
            border: 2px solid #e9ecef;
        }
        .auth-container h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .auth-container form {
            display: flex;
            flex-direction: column;
        }
        .auth-container input {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .auth-container button {
            padding: 10px;
            border: none;
            border-radius: 20px;
            background: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .auth-container button:hover {
            background: #0056b3;
        }
        .auth-container a {
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .auth-container a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1>Login</h1>
        <?php if (isset($login_error)) { echo '<p class="error-message">' . $login_error . '</p>'; } ?>
        <form action="login.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</body>
</html>