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
    <title>NEXUS // Data Core</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="ambient-background">
        <div class="aurora aurora-1"></div>
        <div class="aurora aurora-2"></div>
        
        <div class="particle-system">
            <?php for($i = 1; $i <= 40; $i++): ?>
                <i class="particle" style="animation-delay: <?= $i * 0.075 ?>s; transform: rotate(<?= $i * 9 ?>deg) translate3d(150px, 0, 0);"></i>
            <?php endfor; ?>
        </div>
    </div>

    <div class="layout-wrapper fade-in">
        
        <header class="top-nav">
            <div class="brand">
                <div class="status-indicator"></div>
                <h1>NEXUS<span class="text-dim">_DB</span></h1>
            </div>
            <div class="nav-metrics">
                <span class="mono-text">REGISTROS: <?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
            </div>
        </header>

        <div class="dashboard-grid">
            
            <aside class="glass-card">
                <div class="card-header">
                    <h2>NOVO PROTOCOLO</h2>
                    <p class="text-dim" style="font-size: 0.9rem; margin-bottom: 2rem;">Criptografia e inserção de dados</p>
                </div>
                
                <form action="store.php" method="post" class="neo-form">
                    <div class="form-group">
                        <input type="text" name="name" required placeholder=" ">
                        <label>NOME DO OPERADOR</label>
                        <div class="focus-border"></div>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" required placeholder=" ">
                        <label>ENDEREÇO DE E-MAIL</label>
                        <div class="focus-border"></div>
                    </div>

                    <div class="form-group">
                        <input type="text" name="document" required placeholder=" ">
                        <label>CHAVE DO CURSO</label>
                        <div class="focus-border"></div>
                    </div>

                    <button type="submit" class="btn-glow hover-magnetic">
                        INICIALIZAR CADASTRO
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </form>
            </aside>

            <main class="glass-card table-card">
                <div class="table-scroll">
                    <table class="premium-table">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>OPERADOR</th>
                                <th>CONTATO</th>
                                <th>CURSO</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr style="animation-delay: <?= $index * 0.05 ?>s">
                                    <td class="mono-text text-accent">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                    <td style="font-weight: 600;"><?= htmlspecialchars($user["name"]) ?></td>
                                    <td class="text-dim"><?= htmlspecialchars($user["email"]) ?></td>
                                    <td><span class="badge"><?= htmlspecialchars($user["document"]) ?></span></td>
                                    <td>
                                        <div class="action-group">
                                            <a href="edit.php?id=<?= $user["id"] ?>" class="icon-btn edit-btn hover-magnetic" title="Modificar">
                                                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                            </a>
                                            <a href="delete.php?id=<?= $user["id"] ?>" class="icon-btn delete-btn hover-magnetic custom-delete-btn" title="Purgar">
                                                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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

    <div class="custom-modal-overlay" id="deleteModal">
        <div class="glass-card modal-box">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="2" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <h3 class="modal-title">ALERTA DO SISTEMA</h3>
            <p class="modal-text">Deseja realmente purgar este registro da matriz? Esta ação é irreversível.</p>
            <div class="modal-actions">
                <button class="btn-ghost hover-magnetic" id="btnCancelDelete">ABORTAR</button>
                <button class="btn-glow danger-glow hover-magnetic" id="btnConfirmDelete">CONFIRMAR PURGO</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>