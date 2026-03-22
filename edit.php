<?php
require __DIR__ . "/connect.php";

// 1. Valida e busca o usuário
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) die("ID inválido.");

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$user = $stmt->fetch();

if (!$user) die("Registro não encontrado.");

// 2. Roteamento de Arquitetura
$active_layout = isset($_COOKIE['system_layout']) ? $_COOKIE['system_layout'] : 'omni';

// 3. Chama a View de Edição correta
if ($active_layout === 'aegis') {
    require __DIR__ . "/views/edit_aegis.php";
} else {
    require __DIR__ . "/views/edit_omni.php";
}
?>