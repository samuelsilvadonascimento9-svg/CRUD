<?php
require __DIR__ . "/connect.php";

try {
    $pdo = Connect::getInstance();

    // 1. Cria a tabela de administradores se ela não existir
    $sqlTable = "CREATE TABLE IF NOT EXISTS admins (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($sqlTable);

    // 2. Verifica se o usuário 'admin' já existe
    $stmt = $pdo->prepare("SELECT id FROM admins WHERE username = 'admin'");
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        // 3. Cria a senha criptografada (Nunca salvamos a senha em texto puro!)
        $senha_plana = 'admin';
        $senha_hash = password_hash($senha_plana, PASSWORD_DEFAULT);

        // 4. Insere no banco
        $insert = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:user, :pass)");
        $insert->execute([
            ':user' => 'admin',
            ':pass' => $senha_hash
        ]);

        echo "<h2 style='color: green; font-family: sans-serif;'>✅ Tabela criada e Admin gerado com sucesso!</h2>";
        echo "<p>Usuário: <b>admin</b> | Senha: <b>admin</b></p>";
        echo "<p><b>IMPORTANTE:</b> Você já pode apagar este arquivo (create_admin.php) por segurança.</p>";
        echo "<a href='login.php'>Ir para o Login</a>";
    } else {
        echo "<h2 style='color: orange; font-family: sans-serif;'>⚠️ O usuário 'admin' já existe no banco.</h2>";
        echo "<a href='login.php'>Ir para o Login</a>";
    }

} catch (PDOException $e) {
    die("Erro ao criar admin: " . $e->getMessage());
}
?>