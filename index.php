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
    <title>AURA // Enterprise Core</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="bg-mesh">
        <div class="glow-orb orb-amber"></div>
        <div class="glow-orb orb-pink"></div>
        <div class="glow-orb orb-purple"></div>
    </div>
    <div class="bg-grid"></div>

    <div class="bento-container fade-in">
        
        <header class="bento-item bento-header">
            <div class="brand">
                <div class="core-spinner"></div>
                <h1>AURA<span class="text-dim">_SYS</span></h1>
            </div>
            <div class="nav-metrics">
                <span class="status-dot"></span>
                <span class="mono-text text-amber">SISTEMA ATIVO</span>
            </div>
        </header>

        <aside class="bento-item bento-stats">
            <div class="module-title">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                CARGA DO NÚCLEO
            </div>
            <div class="stat-big">
                <span class="mono-text"><?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
            </div>
            <p class="text-dim">Operadores registrados na matriz de dados.</p>
            
            <div class="mini-chart">
                <div class="bar" style="height: 40%; animation-delay: 0.1s"></div>
                <div class="bar" style="height: 70%; animation-delay: 0.2s"></div>
                <div class="bar" style="height: 50%; animation-delay: 0.3s"></div>
                <div class="bar" style="height: 90%; animation-delay: 0.4s"></div>
                <div class="bar" style="height: 30%; animation-delay: 0.5s"></div>
                <div class="bar" style="height: 100%; animation-delay: 0.6s"></div>
            </div>
        </aside>

        <section class="bento-item bento-form">
            <div class="module-title">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                NOVO PROTOCOLO DE ENTRADA
            </div>
            
            <form action="store.php" method="post" class="aura-form">
                <div class="form-row">
                    <div class="input-box">
                        <input type="text" name="name" required placeholder=" ">
                        <label>NOME DO OPERADOR</label>
                        <div class="input-border"></div>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" required placeholder=" ">
                        <label>ENDEREÇO DE E-MAIL</label>
                        <div class="input-border"></div>
                    </div>
                </div>

                <div class="form-row-single">
                    <div class="input-box">
                        <input type="text" name="document" required placeholder=" ">
                        <label>CHAVE DE ACESSO / CURSO</label>
                        <div class="input-border"></div>
                    </div>
                    <button type="submit" class="btn-premium hover-magnetic">
                        INICIALIZAR 
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </form>
        </section>

        <main class="bento-item bento-table">
            <div class="module-title" style="margin-bottom: 1.5rem;">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                MATRIZ DE DADOS
            </div>
            <div class="table-wrapper">
                <table class="aura-table">
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
                                <td class="mono-text text-amber">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($user["name"]) ?></td>
                                <td class="text-dim"><?= htmlspecialchars($user["email"]) ?></td>
                                <td><span class="chip"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td>
                                    <div class="action-stack">
                                        <a href="edit.php?id=<?= $user["id"] ?>" class="icon-action btn-edit hover-magnetic" title="Modificar">
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                        </a>
                                        <a href="delete.php?id=<?= $user["id"] ?>" class="icon-action btn-delete hover-magnetic custom-delete-btn" title="Purgar">
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

    <div class="aura-modal-overlay" id="deleteModal">
        <div class="aura-modal-box">
            <div class="modal-icon text-pink">
                <svg viewBox="0 0 24 24" width="48" height="48" stroke="currentColor" stroke-width="2" fill="none"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            </div>
            <h3 class="modal-title">EXCLUSÃO CRÍTICA</h3>
            <p class="modal-text">Você está prestes a purgar este operador da matriz central. Os dados serão aniquilados permanentemente.</p>
            <div class="modal-buttons">
                <button class="btn-secondary hover-magnetic" id="btnCancelDelete">CANCELAR</button>
                <button class="btn-danger hover-magnetic" id="btnConfirmDelete">ANIKILAR</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>