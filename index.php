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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // Painel de Controle</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="hologram-bg">
        <div class="ambient-light light-cyan"></div>
        <div class="ambient-light light-magenta"></div>
    </div>

    <div class="dashboard-wrapper">
        
        <header class="sys-header">
            <div class="sys-logo">
                <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                <h1>NEXUS <span class="gradient-text">CORE</span></h1>
            </div>
            <div class="sys-status">
                <span class="status-dot"></span> SISTEMA ONLINE
            </div>
        </header>

        <div class="content-grid">
            
            <aside class="glass-panel input-panel">
                <div class="panel-header">
                    <h2>NOVO REGISTRO</h2>
                    <p>Insira as credenciais do usuário</p>
                </div>
                
                <form action="store.php" method="post" class="neon-form">
                    <div class="input-group">
                        <input type="text" name="name" required id="name">
                        <label for="name">Nome do Operador</label>
                        <div class="input-line"></div>
                    </div>

                    <div class="input-group">
                        <input type="email" name="email" required id="email">
                        <label for="email">Endereço de E-mail</label>
                        <div class="input-line"></div>
                    </div>

                    <div class="input-group">
                        <input type="text" name="document" required id="document">
                        <label for="document">Identificação / Curso</label>
                        <div class="input-line"></div>
                    </div>

                    <button type="submit" class="btn-3d-submit">
                        <span class="btn-text">INICIALIZAR CADASTRO</span>
                        <span class="btn-glare"></span>
                    </button>
                </form>
            </aside>

            <main class="glass-panel data-panel">
                <div class="panel-header flex-between">
                    <h2>BANCO DE DADOS</h2>
                    <div class="data-counter">
                        <?= count($users) ?> REGISTROS
                    </div>
                </div>

                <div class="perspective-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>OPERADOR</th>
                                <th>CONTATO</th>
                                <th>CURSO</th>
                                <th>DATA</th>
                                <th>COMANDOS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr style="animation-delay: <?= $index * 0.1 ?>s">
                                    <td><span class="uid-tag">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span></td>
                                    <td class="primary-text"><?= htmlspecialchars($user["name"]) ?></td>
                                    <td class="muted-text"><?= htmlspecialchars($user["email"]) ?></td>
                                    <td><span class="course-tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                    <td class="muted-text"><?= date("d/m/Y", strtotime($user["created_at"])) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit.php?id=<?= $user["id"] ?>" class="btn-icon edit" title="Editar">
                                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>
                                            <a href="delete.php?id=<?= $user["id"] ?>" class="btn-icon delete" title="Excluir" onclick="return confirm('ATENÇÃO: Excluir registro permanentemente?')">
                                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

</body>
</html>