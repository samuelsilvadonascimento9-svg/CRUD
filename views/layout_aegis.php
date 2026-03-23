<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Tático</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/aegis.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const chartLabels = <?= $chartLabels ?? '[]' ?>;
        const chartData = <?= $chartData ?? '[]' ?>;
        const serverToastSuccess = "<?= $toast_success ?? '' ?>";
        const serverToastError = "<?= $toast_error ?? '' ?>";
    </script>

    <style>
        th.sortable { cursor: pointer; transition: color 0.2s; user-select: none; }
        th.sortable:hover { color: var(--text-white); background: rgba(0, 255, 65, 0.1); }
    </style>
</head>
<body class="dark-theme">

    <div class="crt-scanlines"></div>

    <div class="hud-wrapper">
        <header class="hud-header">
            <div class="header-left">
                <svg viewBox="0 0 100 100" width="40" height="40" class="spin-slow"><circle cx="50" cy="50" r="45" fill="none" stroke="var(--neon-green)" stroke-width="2" stroke-dasharray="10 5 20 5"/><circle cx="50" cy="50" r="30" fill="none" stroke="var(--neon-green)" stroke-width="4" stroke-dasharray="30 10"/></svg>
                <div class="title-group">
                    <h1>PORTAL <span class="text-white">ACADÊMICO</span></h1>
                    <span class="sub-title" data-i18n="conn_status">SECURE CONNECTION ESTABLISHED // V 9.0</span>
                </div>
            </div>
            <div class="header-right">
                <div class="live-clock" id="sys-clock">00:00:00:00</div>
                <div class="status-box">
                    <span class="blink-dot"></span> <span data-i18n="uplink_secure">UPLINK SECURE</span>
                </div>
            </div>
        </header>

        <div class="hud-grid">
            <aside class="side-panel">
                <div class="tactical-box">
                    <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                    <h3 class="box-title">VETORES_DE_DADOS</h3>
                    <div style="width: 100%; display: flex; justify-content: center; padding: 10px;">
                        <canvas id="courseChart"></canvas>
                    </div>
                </div>
                <div class="tactical-box log-box">
                    <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                    <h3 class="box-title">LIVE_TELEMETRY</h3>
                    <div class="terminal-logs" id="terminal-logs"></div>
                </div>
            </aside>

            <main class="main-panel">
                <div class="tabs-nav">
                    <button class="tab-btn active" data-tab="tab-database" data-i18n="tab_db">[ ] MATRIZ DE DADOS</button>
                    <button class="tab-btn" data-tab="tab-insert" data-i18n="tab_add">[+] NOVO UPLINK</button>
                    <button class="tab-btn" data-tab="tab-settings" data-i18n="tab_config">[*] CONFIGS</button>
                    <div class="tabs-line"></div>
                </div>

                <div class="tab-content active" id="tab-database">
                    <div class="tactical-box flex-box">
                        <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                        <div class="table-stats">
                            <span>TOTAL_ENTITIES: <?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
                            <div style="display:flex; gap:10px; align-items:center;">
                                <input type="text" id="tableSearch" placeholder="SEARCH_QUERY..." style="background:transparent; border:1px solid var(--dark-green); color:var(--neon-green); padding:2px 8px; outline:none; font-family:inherit;">
                                <span>ENCRYPTION: AES-256</span>
                            </div>
                        </div>
                        <div class="table-scroll">
                            <table class="aegis-table">
                                <thead>
                                    <tr>
                                        <th>FOTO</th>
                                        <th class="sortable" title="Ordenar por ID">UID ↕</th>
                                        <th class="sortable" title="Ordenar por Nome" data-i18n="th_name">IDENTIFICAÇÃO ALVO ↕</th>
                                        <th class="sortable" title="Ordenar por Curso" data-i18n="th_course">VETOR (CURSO) ↕</th>
                                        <th data-i18n="th_cmd">COMANDOS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr class="table-row glitch-hover">
                                            <td style="width: 50px;">
                                                <img src="uploads/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; border: 1px solid var(--neon-green); filter: grayscale(100%) sepia(100%) hue-rotate(70deg) saturate(300%);">
                                            </td>
                                            <td class="td-id">><?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                            <td>
                                                <div class="text-white fw-bold highlight-target"><?= htmlspecialchars($user["name"]) ?></div>
                                                <div class="text-dim" style="font-size: 0.75rem;">
                                                    <?= htmlspecialchars($user["email"]) ?> | <?= htmlspecialchars($user["phone"] ?? 'N/A') ?>
                                                </div>
                                            </td>
                                            <td><span class="hud-tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                            <td>
                                                <div class="btn-cluster">
                                                    <a href="edit.php?id=<?= $user["id"] ?>" class="hud-icon-btn" title="Interceptar">MOD</a>
                                                    <a href="delete.php?id=<?= $user["id"] ?>" class="hud-icon-btn danger custom-delete-btn" title="Aniquilar">DEL</a>
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
                        <h2 class="form-title">// <span data-i18n="form_title">INICIALIZAR INSERÇÃO DE DADOS</span></h2>
                        <form action="store.php" method="post" enctype="multipart/form-data" class="aegis-form">
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="hud-input-group">
                                    <label data-i18n="label_name">> NOME_DO_OPERADOR</label>
                                    <input type="text" name="name" required autocomplete="off">
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                                <div class="hud-input-group">
                                    <label data-i18n="label_email">> ENDERECO_SINAL (E-MAIL)</label>
                                    <input type="email" name="email" required autocomplete="off">
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                                <div class="hud-input-group">
                                    <label>> DOC_IDENTIFICACAO (CPF)</label>
                                    <input type="text" name="cpf" id="cpfMask" required autocomplete="off" placeholder="000.000.000-00">
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                                <div class="hud-input-group">
                                    <label>> COMUNICADOR_MOVEL (CEL)</label>
                                    <input type="text" name="phone" id="phoneMask" required autocomplete="off" placeholder="(00) 00000-0000">
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                                <div class="hud-input-group">
                                    <label data-i18n="label_course">> CHAVE_VETOR (CURSO)</label>
                                    <select name="document" class="hud-select" required>
                                        <option value="" disabled selected>SELECIONE_O_VETOR...</option>
                                        <option value="Engenharia de Computação">ENGENHARIA_DE_COMPUTACAO</option>
                                        <option value="Ciência da Computação">CIENCIA_DA_COMPUTACAO</option>
                                        <option value="Sistemas de Informação">SISTEMAS_DE_INFORMACAO</option>
                                        <option value="Segurança da Informação">SEGURANCA_DA_INFORMACAO</option>
                                    </select>
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                                <div class="hud-input-group">
                                    <label>> SCAN_BIOMETRICO (FOTO)</label>
                                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp" class="hud-select" style="padding: 9px;">
                                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                                </div>
                            </div>
                            <button type="submit" class="hud-submit-btn" style="margin-top: 30px;">
                                <span data-i18n="btn_uplink">EXECUTE_UPLINK</span><span class="arrow-icon">>></span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="tab-content" id="tab-settings">
                    <div class="tactical-box">
                        <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
                        <h2 class="form-title">// <span data-i18n="settings_header">PREFERÊNCIAS DE SISTEMA</span></h2>
                        <div class="settings-grid">
                            <div class="hud-input-group">
                                <label data-i18n="theme_select">> ESQUEMA_DE_NÚCLEO (TEMA)</label>
                                <select id="theme-selector" class="hud-select">
                                    <option value="dark" data-i18n="theme_dark">OBSIDIAN_DARK</option>
                                    <option value="light" data-i18n="theme_light">PHOSPHOR_LIGHT</option>
                                </select>
                            </div>
                            <div class="hud-input-group">
                                <label data-i18n="lang_select">> CÓDIGO_IDIOMA (LANGUAGE)</label>
                                <select id="lang-selector" class="hud-select">
                                    <option value="pt">Português (BR)</option>
                                    <option value="en">English (US)</option>
                                    <option value="es">Español (ES)</option>
                                </select>
                            </div>
                            <div class="hud-input-group" style="grid-column: 1 / -1; margin-top: 20px;">
                                <label style="color: var(--danger);" data-i18n="layout_select">> ARQUITETURA DO SISTEMA</label>
                                <select id="layout-selector" class="hud-select" style="border-color: var(--danger); color: var(--danger);">
                                    <option value="aegis">Layout Tático (Hacker)</option>
                                    <option value="omni">Layout Corporativo (Clássico)</option>
                                    <option value="quantum">Layout Espacial (Transparente)</option>
                                    <option value="brutal">Layout Pôster (Brutalista)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <div id="aegis-toast" style="position: fixed; bottom: -100px; right: 20px; background: rgba(0,255,65,0.1); border: 1px solid var(--neon-green); color: var(--neon-green); padding: 15px 20px; font-family: 'Share Tech Mono', monospace; transition: 0.4s; z-index: 9999; box-shadow: 0 0 15px rgba(0,255,65,0.2);">
        > <span id="aegis-toast-msg"></span> <span class="blink-dot" style="display:inline-block; margin-left:5px;"></span>
    </div>
    
    <div class="hud-modal-overlay" id="deleteModal">
        <div class="tactical-box modal-box alert-box">
            <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
            <div class="modal-warning-bar">!! WARNING !!</div>
            <h3 class="modal-title" data-i18n="modal_title">PURGA DE SISTEMA SOLICITADA</h3>
            <p class="modal-text" data-i18n="modal_text">Você está prestes a aniquilar este registro. Confirma a exclusão?</p>
            <div class="modal-actions">
                <button class="hud-submit-btn ghost" id="btnCancelDelete" data-i18n="btn_abort">ABORTAR</button>
                <button class="hud-submit-btn danger" id="btnConfirmDelete" data-i18n="btn_confirm">CONFIRMAR</button>
            </div>
        </div>
    </div>

    <script src="assets/js/aegis.js"></script>
</body>
</html>