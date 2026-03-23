<?php
session_start();
require __DIR__ . "/connect.php";

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

try {
    $pdo = Connect::getInstance();
    // O SEGREDO AQUI: 'WHERE deleted_at IS NULL'
    $stmt = $pdo->query("SELECT id, name, email, cpf, phone, document, created_at FROM users WHERE deleted_at IS NULL ORDER BY id DESC");
    $users = $stmt->fetchAll();

    $filename = "relatorio_operadores_" . date('Y-m-d_H-i-s') . ".csv";
    
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $output = fopen('php://output', 'w');
    fputs($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($output, ['ID', 'NOME DO OPERADOR', 'E-MAIL', 'CPF', 'CELULAR', 'CURSO/VETOR', 'DATA DE REGISTRO'], ';');

    foreach ($users as $user) {
        fputcsv($output, [
            $user['id'],
            $user['name'],
            $user['email'],
            $user['cpf'],
            $user['phone'],
            $user['document'],
            date('d/m/Y H:i', strtotime($user['created_at'] ?? 'now'))
        ], ';');
    }

    fclose($output);
    exit;

} catch (PDOException $e) {
    $_SESSION['toast_error'] = "Erro ao gerar relatório.";
    header("Location: index.php");
    exit;
}
?>