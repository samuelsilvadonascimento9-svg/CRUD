<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMNI // Enterprise Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/omni.css">
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar bionic-card">
            <div class="sidebar-header">
                <div class="logo-mark"><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                <span class="logo-text">OMNI.</span>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section" data-i18n="nav_apps">Aplicações</div>
                <button class="nav-item active" data-view="view-dashboard">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                    <span data-i18n="menu_overview">Visão Geral</span>
                </button>
                <button class="nav-item" data-view="view-directory">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                    <span data-i18n="menu_directory">Diretório</span>
                </button>
                <button class="nav-item" data-view="view-insert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span data-i18n="menu_add">Adicionar</span>
                </button>
            </nav>
            <div class="sidebar-footer">
                <div class="nav-section" data-i18n="nav_system">Sistema</div>
                <button class="nav-item" data-view="view-settings">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span data-i18n="menu_settings">Configurações</span>
                </button>
            </div>
        </aside>

        <main class="main-content">
            <section id="view-dashboard" class="view-section active">
                <header class="content-header flex-between">
                    <div><h2 data-i18n="overview_title">Visão Geral</h2><p class="header-subtitle" data-i18n="overview_sub">Monitoramento de dados em tempo real.</p></div>
                    <div class="badge-status"><span class="dot-pulse"></span> <span data-i18n="sys_online">SISTEMA ONLINE</span></div>
                </header>
                <div class="metrics-grid">
                    <div class="metric-card bionic-card"><span class="metric-label" data-i18n="stat_volume">VOLUME DE DADOS</span><span class="metric-value"><?= count($users) ?></span></div>
                    <div class="metric-card bionic-card"><span class="metric-label" data-i18n="stat_integrity">INTEGRIDADE</span><span class="metric-value">100%</span></div>
                    <div class="metric-card bionic-card"><span class="metric-label" data-i18n="stat_latency">LATÊNCIA MÉDIA</span><span class="metric-value">12ms</span></div>
                </div>
                <div class="bionic-card heatmap-section">
                    <h3 data-i18n="activity_map">Mapa de Atividade</h3>
                    <div class="heatmap-grid"><?php for($i=0;$i<114;$i++){ $lv=rand(0,4); echo "<div class='heat-box level-$lv'></div>"; } ?></div>
                </div>
            </section>

            <section id="view-directory" class="view-section">
                <header class="content-header flex-between">
                    <div><h2 data-i18n="dir_title">Diretório</h2><p class="header-subtitle" data-i18n="dir_sub">Gerenciamento de credenciais.</p></div>
                </header>
                <div class="bionic-card table-container">
                    <div class="table-toolbar">
                        <div class="search-input-wrapper">
                            <input type="text" id="tableSearch" placeholder="Pesquisar..." data-i18n-placeholder="search_placeholder">
                        </div>
                    </div>
                    <table class="enterprise-table" id="dataTable">
                        <thead><tr><th>UID</th><th data-i18n="th_name">NOME</th><th data-i18n="th_email">E-MAIL</th><th data-i18n="th_course">CURSO</th><th class="text-right" data-i18n="th_cmd">AÇÕES</th></tr></thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="table-row">
                                <td class="cell-id">#<?= $user["id"] ?></td>
                                <td class="cell-primary"><?= htmlspecialchars($user["name"]) ?></td>
                                <td class="cell-muted"><?= htmlspecialchars($user["email"]) ?></td>
                                <td><span class="tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td class="text-right">
                                    <a href="edit.php?id=<?= $user["id"] ?>" class="btn-ghost-sm" data-i18n="btn_edit">Editar</a>
                                    <a href="delete.php?id=<?= $user["id"] ?>" class="btn-ghost-sm danger custom-delete-btn" data-i18n="btn_del">Apagar</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="view-insert" class="view-section">
                <header class="content-header"><h2 data-i18n="add_title">Novo Operador</h2></header>
                <div class="bionic-card form-card">
                    <form action="store.php" method="post" class="enterprise-form" onsubmit="showToast('Sincronizando...')">
                        <div class="form-grid">
                            <div class="input-block"><label data-i18n="label_name">Nome</label><input type="text" name="name" required></div>
                            <div class="input-block"><label data-i18n="th_email">Email</label><input type="email" name="email" required></div>
                        </div>
                        <div class="input-block" style="margin-top:20px"><label data-i18n="label_course">Curso</label><input type="text" name="document" required></div>
                        <div class="form-footer"><button type="submit" class="btn-primary w-full" data-i18n="btn_save">Salvar</button></div>
                    </form>
                </div>
            </section>

            <section id="view-settings" class="view-section">
                <header class="content-header"><h2 data-i18n="settings_title">Configurações do Sistema</h2></header>
                <div class="metrics-grid" style="grid-template-columns: 1fr 1fr;">
                    
                    <div class="bionic-card form-card" style="max-width:100%">
                        <h3 style="margin-bottom:20px" data-i18n="visual_prefs">Preferências Visuais</h3>
                        
                        <div class="setting-item">
                            <label data-i18n="theme_select">Tema</label>
                            <select id="theme-selector" class="neo-select">
                                <option value="dark" data-i18n="opt_dark">Escuro OLED</option>
                                <option value="light" data-i18n="opt_light">Claro Minimal</option>
                            </select>
                        </div>
                        
                        <div class="setting-item" style="margin-top:20px">
                            <label data-i18n="lang_select">Idioma</label>
                            <select id="lang-selector" class="neo-select">
                                <option value="pt">Português (BR)</option>
                                <option value="en">English (US)</option>
                                <option value="es">Español (ES)</option>
                            </select>
                        </div>

                        <div class="setting-item" style="margin-top:20px; padding-top: 20px; border-top: 1px solid var(--border-subtle);">
                            <label data-i18n="layout_select" style="color: var(--success);">Arquitetura do Sistema</label>
                            <select id="layout-selector" class="neo-select">
                                <option value="omni">OMNI (Corporativo Sênior)</option>
                                <option value="aegis">AEGIS (Tático Hacker)</option>
                            </select>
                        </div>

                    </div>

                    <div class="bionic-card form-card" style="max-width:100%">
                        <h3 style="margin-bottom:20px" data-i18n="diag_title">Status de Segurança</h3>
                        <ul class="settings-list">
                            <li><span data-i18n="diag_xss">Prevenção XSS</span> <strong data-i18n="diag_active">Ativa</strong></li>
                            <li><span data-i18n="diag_sql">SQL Injection</span> <strong data-i18n="diag_active">Bloqueado</strong></li>
                            <li><span>PHP Routing</span> <strong>Ativo (MVC)</strong></li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div id="toast" class="toast-notification"><span id="toast-msg"></span></div>

    <div class="dialog-overlay" id="deleteModal">
        <div class="bionic-card dialog-box">
            <div class="dialog-header"><h3 data-i18n="modal_confirm">Confirmar Exclusão</h3></div>
            <div class="dialog-content"><p data-i18n="modal_text">Esta ação é permanente.</p></div>
            <div class="dialog-footer">
                <button class="btn-secondary" id="btnCancelDelete" data-i18n="btn_cancel">Cancelar</button>
                <button class="btn-danger" id="btnConfirmDelete" data-i18n="btn_del_confirm">Excluir</button>
            </div>
        </div>
    </div>
    
    <script src="assets/js/omni.js"></script>
</body>
</html>