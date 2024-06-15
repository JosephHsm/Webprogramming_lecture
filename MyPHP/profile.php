<?php
session_start();
include 'config.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// POST 요청을 통해 프로필 업데이트
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $height = isset($data['height']) ? (float)$data['height'] : 0;
    $weight = isset($data['weight']) ? (float)$data['weight'] : 0;
    $body_fat = isset($data['body_fat']) ? (float)$data['body_fat'] : 0;

    $stmt = $pdo->prepare('UPDATE users SET height = ?, weight = ?, body_fat = ? WHERE username = ?');
    $stmt->execute([$height, $weight, $body_fat, $username]);

    echo json_encode(['success' => true]);
    exit();
}