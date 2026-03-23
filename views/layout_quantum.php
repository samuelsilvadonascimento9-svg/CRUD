<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Espacial</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/css/quantum.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const chartLabels = <?= $chartLabels ?? '[]' ?>;
        const chartData = <?= $chartData ?? '[]' ?>;
        const serverToastSuccess = "<?= $toast_success ?? '' ?>";
        const serverToastError = "<?= $toast_error ?? '' ?>";
    </script>

    <style>
        th.sortable { cursor: pointer; transition: color 0.2s; user-select: none; }
        th.sortable:hover { color: var(--liquid-accent); }
        .spatial-window { backdrop-filter: blur(15px); }
    </style>
</head>
<body class="dark-theme"> <div class="liquid-desktop">
        <div class="liquid-blob blob-1"></div><div class="liquid-blob blob-2"></div><div class="liquid-blob blob-3"></div>
    </div>
    <div class="noise-overlay"></div>

    <div class="desktop-environment">
        
        <div class="spatial-window app-input active" id="window-input" style="left: 5%; top: 10%; z-index: 2; width: 450px;">
            <div class="window-bar cursor-grab">
                <div class="window-controls"><span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span></div>
                <span class="window-title mono" data-i18n="add_title">TERMINAL DE ENTRADA v.4.0</span>
            </div>
            <div class="window-content">
                <form action="store.php" method="post" enctype="multipart/form-data" class="quantum-form">
                    <div class="q-input-group">
                        <label data-i18n="label_name">IDENTIFICAÇÃO DO OPERADOR</label>
                        <input type="text" name="name" required placeholder="_Digite o nome completo">
                        <span class="input-focus-line"></span>
                    </div>
                    <div class="q-input-group">
                        <label data-i18n="label_email">CANAL DE COMUNICAÇÃO (E-MAIL)</label>
                        <input type="email" name="email" required placeholder="_Digite o endereço">
                        <span class="input-focus-line"></span>
                    </div>
                    
                    <div style="display: flex; gap: 15px;">
                        <div class="q-input-group" style="flex: 1;">
                            <label>DOC (CPF)</label>
                            <input type="text" name="cpf" id="cpfMask" required placeholder="000.000.000-00">
                            <span class="input-focus-line"></span>
                        </div>
                        <div class="q-input-group" style="flex: 1;">
                            <label>CELULAR</label>
                            <input type="text" name="phone" id="phoneMask" required placeholder="(00) 00000-0000">
                            <span class="input-focus-line"></span>
                        </div>
                    </div>

                    <div class="q-input-group">
                        <label data-i18n="label_course">VETOR DE ACESSO (CURSO)</label>
                        <select name="document" class="q-select" required>
                            <option value="" disabled selected>_Selecione o curso</option>
                            <option value="Engenharia de Computação">Engenharia de Computação</option>
                            <option value="Ciência da Computação">Ciência da Computação</option>
                            <option value="Sistemas de Informação">Sistemas de Informação</option>
                            <option value="Segurança da Informação">Segurança da Informação</option>
                        </select>
                        <span class="input-focus-line"></span>
                    </div>

                    <div class="q-input-group">
                        <label>SCAN BIOMÉTRICO (FOTO)</label>
                        <input type="file" name="avatar" class="q-select" accept="image/png, image/jpeg, image/webp" style="padding: 12px 15px;">
                        <span class="input-focus-line"></span>
                    </div>

                    <button type="submit" class="quantum-btn primary" style="margin-top: 15px;">
                        <span class="btn-txt" data-i18n="btn_save">PROCESSAR DADOS</span>
                        <div class="btn-glitch"></div>
                    </button>
                </form>
            </div>
        </div>

        <div class="spatial-window app-data active" id="window-data" style="right: 5%; top: 5%; z-index: 3; width: 750px;">
            <div class="window-bar cursor-grab">
                <div class="window-controls"><span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span></div>
                <span class="window-title mono" data-i18n="dir_title">VISUALIZADOR DE MATRIZ</span>
            </div>
            <div class="window-content scrollable">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <div style="width: 150px; height: 150px;">
                        <canvas id="courseChart"></canvas>
                    </div>
                    <div style="display: flex; align-items: flex-end; gap: 10px;">
                        <div class="q-input-group" style="width: 250px; margin-bottom: 0;">
                            <label>LOCALIZAR DADOS</label>
                            <input type="text" id="tableSearch" placeholder="_Pesquise...">
                            <span class="input-focus-line"></span>
                        </div>
                        <a href="export.php" class="quantum-btn secondary" style="text-decoration: none; height: 44px; display: flex; align-items: center; padding: 0 15px; border-radius: 8px; font-size: 0.75rem; font-weight: 800;">📥 EXPORTAR</a>
                    </div>
                </div>

                <table class="quantum-table">
                    <thead>
                        <tr>
                            <th>FOTO</th>
                            <th class="sortable">UID ↕</th>
                            <th class="sortable" data-i18n="th_name">Operador ↕</th>
                            <th class="sortable" data-i18n="th_course">Vetor ↕</th>
                            <th data-i18n="th_cmd">Controle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user) : ?>
                            <tr class="table-row">
                                <td style="width: 50px;">
                                    <img src="uploads/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover; border: 1px solid rgba(255,255,255,0.1);">
                                </td>
                                <td class="mono-id">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="user-cell">
                                        <span class="user-name highlight-target"><?= htmlspecialchars($user["name"]) ?></span>
                                        <span class="user-email mono" style="font-size: 0.65rem; opacity: 0.7;">
                                            <?= htmlspecialchars($user["email"]) ?> | <?= htmlspecialchars($user["phone"] ?? '') ?>
                                        </span>
                                    </div>
                                </td>
                                <td><span class="vector-badge"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td>
                                    <div class="control-btns">
                                        <a href="edit.php?id=<?= $user["id"] ?>" class="q-icon-btn edit">✏️</a>
                                        <button data-href="delete.php?id=<?= $user["id"] ?>" class="q-icon-btn delete custom-delete-trigger">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="spatial-window app-settings" id="window-settings" style="left: 35%; top: 30%; z-index: 1;">
            <div class="window-bar cursor-grab">
                <div class="window-controls"><span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span></div>
                <span class="window-title mono" data-i18n="settings_title">PREFERÊNCIAS</span>
            </div>
            <div class="window-content">
                <div class="q-input-group" style="margin-bottom: 15px;">
                    <label>IDIOMA</label>
                    <select id="lang-selector" class="q-select">
                        <option value="pt">Português (BR)</option>
                        <option value="en">English (US)</option>
                        <option value="es">Español (ES)</option>
                    </select>
                </div>

                <div class="q-input-group" style="margin-bottom: 15px;">
                    <label data-i18n="theme_select">ESQUEMA DE CORES</label>
                    <select id="theme-selector" class="q-select">
                        <option value="dark">Deep Space (Escuro)</option>
                        <option value="light">Anti-Matter (Claro)</option>
                    </select>
                </div>

                <div class="q-input-group">
                    <label>ARQUITETURA</label>
                    <select id="layout-selector" class="q-select">
                        <option value="quantum">Layout Espacial</option>
                        <option value="omni">Layout Corporativo</option>
                        <option value="aegis">Layout Tático</option>
                        <option value="brutal">Layout Pôster</option>
                    </select>
                </div>
                <a href="logout.php" class="quantum-btn danger" style="margin-top: 20px; text-decoration: none; display: block; text-align: center; border-radius: 8px;">
                    <span class="btn-txt">ENCERRAR SESSÃO</span>
                </a>
            </div>
        </div>
    </div> 

    <div class="dock-container">
        <div class="quantum-dock">
            <button class="dock-icon active" data-target="window-input"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path></svg><div class="dock-glow"></div></button>
            <button class="dock-icon active" data-target="window-data"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline></svg><div class="dock-glow"></div></button>
            <button class="dock-icon" data-target="window-settings"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0"></path></svg><div class="dock-glow"></div></button>
        </div>
    </div>

    <div id="quantum-toast" style="position: fixed; bottom: -100px; left: 50%; transform: translateX(-50%); background: rgba(10, 10, 20, 0.9); backdrop-filter: blur(10px); border: 1px solid var(--liquid-accent); color: #FFF; padding: 15px 30px; border-radius: 30px; font-family: 'Space Mono', monospace; transition: 0.4s; z-index: 9999; box-shadow: 0 10px 40px rgba(0,0,0,0.5);">
        <span id="quantum-toast-msg"></span>
    </div>

    <div class="spatial-modal-overlay" id="deleteModal">
        <div class="spatial-window modal-window">
             <div class="window-bar box-danger"><span class="window-title mono">ALERTA CRÍTICO</span></div>
            <div class="window-content text-center">
                <div class="danger-icon">⚠️</div>
                <h3 style="color: #fff; margin-bottom: 10px;">Mover para lixeira?</h3>
                <div class="modal-actions">
                    <button class="quantum-btn secondary" id="btnCancelDelete">CANCELAR</button>
                    <button class="quantum-btn danger" id="btnConfirmDelete">CONFIRMAR</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/js/quantum.js"></script>
</body>
</html>