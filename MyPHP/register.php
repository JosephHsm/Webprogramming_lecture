<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        $register_error = 'Username already exists. Please choose another.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
        $stmt->execute([$username, $password]);
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
        <h1>Register</h1>
        <?php if (isset($register_error)) { echo '<p class="error-message">' . $register_error . '</p>'; } ?>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>
