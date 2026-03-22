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
    <title>QUANTUM OS // Spatial Interface</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="liquid-desktop">
        <div class="liquid-blob blob-1"></div>
        <div class="liquid-blob blob-2"></div>
        <div class="liquid-blob blob-3"></div>
    </div>
    <div class="noise-overlay"></div>

    <div class="desktop-environment">
        
        <div class="spatial-window app-input active" id="window-input" style="left: 10%; top: 15%; z-index: 2;">
            <div class="window-bar cursor-grab">
                <div class="window-controls">
                    <span class="win-btn close-btn"></span>
                    <span class="win-btn minimize-btn"></span>
                </div>
                <span class="window-title mono">TERMINAL DE ENTRADA v.4.0</span>
            </div>
            <div class="window-content">
                <form action="store.php" method="post" class="quantum-form">
                    <div class="q-input-group">
                        <label>IDENTIFICAÇÃO DO OPERADOR</label>
                        <input type="text" name="name" required placeholder="_Digite o nome completo">
                        <span class="input-focus-line"></span>
                    </div>
                    <div class="q-input-group">
                        <label>CANAL DE COMUNICAÇÃO (E-MAIL)</label>
                        <input type="email" name="email" required placeholder="_Digite o e-mail corporativo">
                        <span class="input-focus-line"></span>
                    </div>
                    <div class="q-input-group">
                        <label>VETOR DE ACESSO (CURSO)</label>
                        <input type="text" name="document" required placeholder="_Código do curso">
                        <span class="input-focus-line"></span>
                    </div>
                    <button type="submit" class="quantum-btn primary">
                        <span class="btn-txt">PROCESSAR DADOS</span>
                        <div class="btn-glitch"></div>
                    </button>
                </form>
            </div>
        </div>

        <div class="spatial-window app-data active" id="window-data" style="right: 5%; top: 10%; z-index: 3; width: 650px;">
            <div class="window-bar cursor-grab">
                <div class="window-controls">
                    <span class="win-btn close-btn"></span>
                    <span class="win-btn minimize-btn"></span>
                </div>
                <span class="window-title mono">VISUALIZADOR DE MATRIZ [Registros: <?= count($users) ?>]</span>
            </div>
            <div class="window-content scrollable">
                <table class="quantum-table">
                    <thead>
                        <tr>
                            <th>UID</th>
                            <th>Operador / Contato</th>
                            <th>Vetor</th>
                            <th>Controle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user) : ?>
                            <tr style="animation-delay: <?= $index * 0.05 ?>s">
                                <td class="mono-id">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="user-cell">
                                        <span class="user-name"><?= htmlspecialchars($user["name"]) ?></span>
                                        <span class="user-email mono"><?= htmlspecialchars($user["email"]) ?></span>
                                    </div>
                                </td>
                                <td><span class="vector-badge"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td>
                                    <div class="control-btns">
                                        <a href="edit.php?id=<?= $user["id"] ?>" class="q-icon-btn edit" title="Reconfigurar">
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </a>
                                        <button data-href="delete.php?id=<?= $user["id"] ?>" class="q-icon-btn delete custom-delete-trigger" title="Purgar">
                                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <div class="dock-container">
        <div class="quantum-dock">
            <button class="dock-icon active" data-target="window-input" title="Terminal de Entrada">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                <div class="dock-glow"></div>
            </button>
            <button class="dock-icon active" data-target="window-data" title="Visualizador de Matriz">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <div class="dock-glow"></div>
            </button>
        </div>
    </div>

    <div class="spatial-modal-overlay" id="deleteModal">
        <div class="spatial-window modal-window">
             <div class="window-bar box-danger">
                <span class="window-title mono">ALERTA DE SISTEMA CRÍTICO</span>
            </div>
            <div class="window-content text-center">
                <div class="danger-icon">⚠️</div>
                <h3 class="modal-heading">Confirmar Purga de Dados?</h3>
                <p class="modal-desc">Esta operação é irreversível e removerá permanentemente o registro da matriz quântica.</p>
                <div class="modal-actions">
                    <button class="quantum-btn secondary" id="btnCancelDelete">CANCELAR OPERAÇÃO</button>
                    <button class="quantum-btn danger" id="btnConfirmDelete">CONFIRMAR PURGA</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>