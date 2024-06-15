<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
include 'config.php';

$day = $_GET['day'];

$stmt = $pdo->prepare('SELECT * FROM routines WHERE day = ?');
$stmt->execute([$day]);
$routines = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($routines);
?>