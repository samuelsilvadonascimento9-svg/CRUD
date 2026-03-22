<?php
require __DIR__ . "/connect.php";

$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>SISTEMA // ALUNOS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="bg-abstract">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
    </div>

    <div class="container">
        
        <header class="header-glass">
            <h1><span class="neon-dot">::</span> DATA_BASE <span class="neon-text">ALUNOS</span></h1>
            <p>SISTEMA DE GERENCIAMENTO DE MATRÍCULAS</p>
        </header>

        <section class="glass-panel">
            <h2 class="section-title">NOVO REGISTRO</h2>
            <form action="store.php" method="post" class="cyber-form">
                <div class="input-wrapper">
                    <input type="text" name="name" required placeholder=" ">
                    <label>NOME DO OPERADOR</label>
                </div>

                <div class="input-wrapper">
                    <input type="email" name="email" required placeholder=" ">
                    <label>ENDEREÇO DE E-MAIL</label>
                </div>

                <div class="input-wrapper">
                    <input type="text" name="document" required placeholder=" ">
                    <label>CURSO VINCULADO</label>
                </div>

                <button type="submit" class="btn-neon">INICIALIZAR CADASTRO</button>
            </form>
        </section>

        <section class="glass-panel">
            <div class="table-header">
                <h2 class="section-title">REGISTROS ATIVOS</h2>
                <span class="badge-count">TOTAL: <?= count($users) ?></span>
            </div>
            
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>UID</th>
                            <th>IDENTIFICAÇÃO</th>
                            <th>E-MAIL</th>
                            <th>CURSO</th>
                            <th>DATA DE ACESSO</th>
                            <th>COMANDOS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td><span class="id-badge">#<?= $user["id"] ?></span></td>
                                <td class="fw-bold text-white"><?= htmlspecialchars($user["name"]) ?></td>
                                <td><?= htmlspecialchars($user["email"]) ?></td>
                                <td><span class="tag-curso"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td class="text-muted"><?= date("d/m/Y", strtotime($user["created_at"])) ?></td>
                                <td class="actions-cell">
                                    <a href="edit.php?id=<?= $user["id"] ?>" class="btn-action edit">EDITAR</a>
                                    <a href="delete.php?id=<?= $user["id"] ?>" class="btn-action delete" onclick="return confirm('ALERTA: Confirmar exclusão do registro?')">EXCLUIR</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </div>
</body>
</html>