<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUANTUM OS // Spatial Interface</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/quantum.css">
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
                    <span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span>
                </div>
                <span class="window-title mono" data-i18n="add_title">TERMINAL DE ENTRADA v.4.0</span>
            </div>
            <div class="window-content">
                <form action="store.php" method="post" class="quantum-form">
                    <div class="q-input-group">
                        <label data-i18n="label_name">IDENTIFICAÇÃO DO OPERADOR</label>
                        <input type="text" name="name" required placeholder="_Digite o nome completo">
                        <span class="input-focus-line"></span>
                    </div>
                    <div class="q-input-group">
                        <label data-i18n="label_email">CANAL DE COMUNICAÇÃO (E-MAIL)</label>
                        <input type="email" name="email" required placeholder="_Digite o e-mail corporativo">
                        <span class="input-focus-line"></span>
                    </div>
                    <div class="q-input-group">
                        <label data-i18n="label_course">VETOR DE ACESSO (CURSO)</label>
                        <input type="text" name="document" required placeholder="_Código do curso">
                        <span class="input-focus-line"></span>
                    </div>
                    <button type="submit" class="quantum-btn primary">
                        <span class="btn-txt" data-i18n="btn_save">PROCESSAR DADOS</span>
                        <div class="btn-glitch"></div>
                    </button>
                </form>
            </div>
        </div>

        <div class="spatial-window app-data active" id="window-data" style="right: 5%; top: 10%; z-index: 3; width: 650px;">
            <div class="window-bar cursor-grab">
                <div class="window-controls">
                    <span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span>
                </div>
                <span class="window-title mono" data-i18n="dir_title">VISUALIZADOR DE MATRIZ [Registros: <?= count($users) ?>]</span>
            </div>
            <div class="window-content scrollable">
                <table class="quantum-table">
                    <thead>
                        <tr>
                            <th>UID</th><th data-i18n="th_name">Operador / Contato</th><th data-i18n="th_course">Vetor</th><th data-i18n="th_cmd">Controle</th>
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

        <div class="spatial-window app-settings" id="window-settings" style="left: 35%; top: 30%; z-index: 1;">
            <div class="window-bar cursor-grab">
                <div class="window-controls">
                    <span class="win-btn close-btn"></span><span class="win-btn minimize-btn"></span>
                </div>
                <span class="window-title mono" data-i18n="settings_title">PREFERÊNCIAS DE SISTEMA</span>
            </div>
            <div class="window-content">
                <div class="q-input-group" style="margin-bottom: 15px;">
                    <label data-i18n="lang_select">IDIOMA DO SISTEMA</label>
                    <select id="lang-selector" class="q-select">
                        <option value="pt">Português (BR)</option>
                        <option value="en">English (US)</option>
                        <option value="es">Español (ES)</option>
                    </select>
                </div>
                <div class="q-input-group" style="margin-bottom: 15px;">
                    <label data-i18n="theme_select">ESQUEMA DE CORES</label>
                    <select id="theme-selector" class="q-select">
                        <option value="dark">Deep Space (Dark)</option>
                        <option value="light">Anti-Matter (Light)</option>
                    </select>
                </div>
                <div class="q-input-group">
                    <label data-i18n="layout_select" style="color: var(--liquid-accent);">ARQUITETURA DO SISTEMA</label>
                    <select id="layout-selector" class="q-select" style="border-color: var(--liquid-accent);">
                        <option value="quantum">QUANTUM (Spatial OS)</option>
                        <option value="omni">OMNI (Corporativo Sênior)</option>
                        <option value="aegis">AEGIS (Tático Hacker)</option>
                    </select>
                </div>
            </div>
        </div>

    </div> 

    <div class="dock-container">
        <div class="quantum-dock">
            <button class="dock-icon active" data-target="window-input" title="Terminal de Entrada">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                <div class="dock-glow"></div>
            </button>
            <button class="dock-icon active" data-target="window-data" title="Visualizador de Matriz">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <div class="dock-glow"></div>
            </button>
            <button class="dock-icon" data-target="window-settings" title="Configurações">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
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
                <h3 class="modal-heading" data-i18n="modal_confirm">Confirmar Purga de Dados?</h3>
                <p class="modal-desc" data-i18n="modal_text">Esta operação é irreversível.</p>
                <div class="modal-actions">
                    <button class="quantum-btn secondary" id="btnCancelDelete" data-i18n="btn_cancel">CANCELAR</button>
                    <button class="quantum-btn danger" id="btnConfirmDelete" data-i18n="btn_confirm">CONFIRMAR PURGA</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/quantum.js"></script>
</body>
</html>