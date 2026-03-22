<?php
require __DIR__ . "/connect.php";

// 1. Busca os dados
$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();

// 2. Roteamento de Arquitetura
$active_layout = isset($_COOKIE['system_layout']) ? $_COOKIE['system_layout'] : 'omni';

// 3. Chama a View correta de dentro da pasta "views"
if ($active_layout === 'aegis') {
    require __DIR__ . "/views/layout_aegis.php";
} else {
    require __DIR__ . "/views/layout_omni.php";
}
?>