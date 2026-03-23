<?php
require __DIR__ . "/connect.php";
try {
    $pdo = Connect::getInstance();
    // Adiciona a coluna que vai funcionar como a nossa "Lixeira Virtual"
    $pdo->exec("ALTER TABLE users ADD COLUMN deleted_at TIMESTAMP NULL DEFAULT NULL");
    echo "<h2 style='color:green'>Coluna 'deleted_at' criada com sucesso! Podes apagar este ficheiro.</h2>";
} catch (PDOException $e) {
    echo "A coluna já existe ou ocorreu um erro: " . $e->getMessage();
}
?>