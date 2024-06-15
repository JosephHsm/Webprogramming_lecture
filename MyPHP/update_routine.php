<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'];
$checked = $data['checked'] ? 1 : 0;

// 루틴의 체크 상태 업데이트
$stmt = $pdo->prepare('UPDATE routines SET checked = ? WHERE id = ?');
$stmt->execute([$checked, $id]);

echo json_encode(['success' => true]);
?>