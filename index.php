<?php
session_start();
require __DIR__ . "/connect.php";

// ISOLANDO O PROBLEMA: Definindo o caminho base do seu projeto
$baseUrl = "/devweb/CRUD"; 

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users WHERE deleted_at IS NULL ORDER BY id DESC");
$users = $stmt->fetchAll();

$coursesCount = [];
foreach ($users as $u) {
    $curso = $u['document'];
    if (!empty($curso)) {
        $coursesCount[$curso] = ($coursesCount[$curso] ?? 0) + 1;
    }
}
$chartLabels = json_encode(array_keys($coursesCount));
$chartData = json_encode(array_values($coursesCount));

$toast_success = $_SESSION['toast_success'] ?? '';
$toast_error = $_SESSION['toast_error'] ?? '';
unset($_SESSION['toast_success'], $_SESSION['toast_error']); 

$active_layout = isset($_COOKIE['system_layout']) ? $_COOKIE['system_layout'] : 'omni';

if ($active_layout === 'aegis') {
    require __DIR__ . "/views/layout_aegis.php";
} elseif ($active_layout === 'quantum') {
    require __DIR__ . "/views/layout_quantum.php";
} elseif ($active_layout === 'brutal') {
    require __DIR__ . "/views/layout_brutal.php";
} else {
    require __DIR__ . "/views/layout_omni.php";
}
?>