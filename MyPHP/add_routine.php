<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$day = $data['day'];
$text = $data['text'];

$stmt = $pdo->prepare('INSERT INTO routines (day, text) VALUES (?, ?)');
$stmt->execute([$day, $text]);

echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
?>