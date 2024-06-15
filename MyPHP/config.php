<?php
$host = 'localhost';
$db = 'exercise_db';  // 데이터베이스 이름
$user = 'root';       // 데이터베이스 사용자
$pass = '';           // 데이터베이스 비밀번호

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>