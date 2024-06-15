<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php';

// 모든 루틴의 체크 상태를 해제
$stmt = $pdo->prepare('UPDATE routines SET checked = 0');
$stmt->execute();

echo 'All routines have been unchecked!';
?>