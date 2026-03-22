<?php
require __DIR__ . "/connect.php";
$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();

// Sistema Avançado de Roteamento de Layouts (3 Opções)
$active_layout = isset($_COOKIE['system_layout']) ? $_COOKIE['system_layout'] : 'omni';

if ($active_layout === 'aegis') {
    require __DIR__ . "/views/layout_aegis.php";
} elseif ($active_layout === 'quantum') {
    require __DIR__ . "/views/layout_quantum.php";
} else {
    require __DIR__ . "/views/layout_omni.php";
}
?>