<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];

$stmt = $pdo->prepare('DELETE FROM routines WHERE id = ?');
$stmt->execute([$id]);

echo json_encode(['success' => true]);
?>