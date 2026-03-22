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
    <title>AEGIS // Tactical HUD</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="crt-scanlines"></div>

    <div class="hud-wrapper">
        
        <header class="hud-header">
            <div class="header-left">
                <svg viewBox="0 0 100 100" width="40" height="40" class="spin-slow"><circle cx="50" cy="50" r="45" fill="none" stroke="var(--neon-green)" stroke-width="2" stroke-dasharray="10 5 20 5"/><circle cx="50" cy="50" r="30" fill="none" stroke="var(--neon-green)" stroke-width="4" stroke-dasharray="30 10"/></svg>
                <div class="title-group">
                    <h1>AEGIS <span class="text-white">COMMAND</span></h1>
                    <span class="sub-title">SECURE CONNECTION ESTABLISHED // V 9.0</span>
                </div>
            </div>
            <div class="header-right">
                <div class="live-clock" id="sys-clock">00:00:00:00</div>
                <div class="status-box">
                    <span class="blink-dot"></span> UPLINK SECURE
                </div>
            </div>
        </header>

        <div class="hud-grid">
            
            <aside class="side-panel">
                <div class="tactical-box">
                    <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                    <h3 class="box-title">SYS_RADAR</h3>
                    <div class="radar-container">
                        <div class="radar">
                            <div class="sweep"></div>
                        </div>
                        <div class="target-blip"></div>
                    </div>
                </div>

                <div class="tactical-box log-box">
                    <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                    <h3 class="box-title">LIVE_TELEMETRY</h3>
                    <div class="terminal-logs" id="terminal-logs">
                        </div>
                </div>
            </aside>

            <main class="main-panel">
                
                <div class="tabs-nav">
                    <button class="tab-btn active" data-tab="tab-database">
                        <span class="tab-icon">[ ]</span> MATRIZ DE DADOS
                    </button>
                    <button class="tab-btn" data-tab="tab-insert">
                        <span class="tab-icon">[+]</span> NOVO UPLINK
                    </button>
                    <div class="tabs-line"></div>
                </div>

                <div class="tab-content active" id="tab-database">
                    <div class="tactical-box flex-box">
                        <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                        
                        <div class="table-stats">
                            <span>TOTAL_ENTITIES: <?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
                            <span>ENCRYPTION: AES-256</span>
                        </div>

                        <div class="table-scroll">
                            <table class="aegis-table">
                                <thead>
                                    <tr>
                                        <th>UID</th>
                                        <th>IDENTIFICAÇÃO ALVO</th>
                                        <th>SINAL (E-MAIL)</th>
                                        <th>VETOR (CURSO)</th>
                                        <th>COMANDOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr class="glitch-hover">
                                            <td class="td-id">><?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                            <td class="text-white fw-bold"><?= htmlspecialchars($user["name"]) ?></td>
                                            <td class="text-dim"><?= htmlspecialchars($user["email"]) ?></td>
                                            <td><span class="hud-tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                            <td>
                                                <div class="btn-cluster">
                                                    <a href="edit.php?id=<?= $user["id"] ?>" class="hud-icon-btn" title="Interceptar (Editar)">MOD</a>
                                                    <a href="delete.php?id=<?= $user["id"] ?>" class="hud-icon-btn danger custom-delete-btn" title="Aniquilar (Excluir)">DEL</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-content" id="tab-insert">
                    <div class="tactical-box">
                        <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                        
                        <h2 class="form-title">// INICIALIZAR INSERÇÃO DE DADOS</h2>
                        
                        <form action="store.php" method="post" class="aegis-form">
                            <div class="hud-input-group">
                                <label>> NOME_DO_OPERADOR</label>
                                <input type="text" name="name" required autocomplete="off">
                                <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                            </div>

                            <div class="hud-input-group">
                                <label>> ENDERECO_SINAL (E-MAIL)</label>
                                <input type="email" name="email" required autocomplete="off">
                                <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                            </div>

                            <div class="hud-input-group">
                                <label>> CHAVE_VETOR (CURSO)</label>
                                <input type="text" name="document" required autocomplete="off">
                                <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                            </div>

                            <button type="submit" class="hud-submit-btn">
                                EXECUTE_UPLINK 
                                <span class="arrow-icon">>></span>
                            </button>
                        </form>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <div class="hud-modal-overlay" id="deleteModal">
        <div class="tactical-box modal-box alert-box">
            <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
            <div class="modal-warning-bar">!! WARNING !!</div>
            
            <h3 class="modal-title">PURGA DE SISTEMA SOLICITADA</h3>
            <p class="modal-text">Você está prestes a aniquilar este registro do servidor central. Confirma a exclusão dos dados?</p>
            
            <div class="modal-actions">
                <button class="hud-submit-btn ghost" id="btnCancelDelete">ABORT</button>
                <button class="hud-submit-btn danger" id="btnConfirmDelete">CONFIRM_DEL</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>