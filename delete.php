<?php
session_start();
require __DIR__ . "/connect.php";

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['toast_error'] = "ID inválido.";
    header("Location: index.php");
    exit;
}

$pdo = Connect::getInstance();
// A MÁGICA DO SOFT DELETE AQUI: UPDATE em vez de DELETE
$stmt = $pdo->prepare("UPDATE users SET deleted_at = CURRENT_TIMESTAMP WHERE id = :id");

try {
    $stmt->execute([":id" => $id]);
    $_SESSION['toast_success'] = "Registro movido para a lixeira com sucesso!";
} catch (PDOException $e) {
    $_SESSION['toast_error'] = "Erro interno ao apagar registro.";
}

header("Location: index.php");
exit;
?>