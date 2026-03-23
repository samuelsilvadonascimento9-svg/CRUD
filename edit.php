<?php
require __DIR__ . "/connect.php";

// ==========================================
// PROTEÇÃO DA ROTA (SÓ ENTRA LOGADO)
// ==========================================
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) die("ID inválido.");

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$user = $stmt->fetch();

if (!$user) die("Registro não encontrado.");

$active_layout = isset($_COOKIE['system_layout']) ? $_COOKIE['system_layout'] : 'omni';

if ($active_layout === 'aegis') {
    require __DIR__ . "/views/edit_aegis.php";
} elseif ($active_layout === 'quantum') {
    require __DIR__ . "/views/edit_quantum.php";
} elseif ($active_layout === 'brutal') {
    require __DIR__ . "/views/edit_brutal.php";
} else {
    require __DIR__ . "/views/edit_omni.php";
}
?>