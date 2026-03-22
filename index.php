<?php
require __DIR__ . "/connect.php";
$pdo = Connect::getInstance();
$stmt = $pdo->query("SELECT * FROM users ORDER BY id DESC");
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMNI // Enterprise Platform</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="app-layout">
        
        <aside class="sidebar bionic-card">
            <div class="sidebar-header">
                <div class="logo-mark">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <span class="logo-text">OMNI.</span>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section" data-i18n="nav_apps">Aplicações</div>
                <button class="nav-item active" data-view="view-dashboard">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                    <span data-i18n="menu_overview">Visão Geral</span>
                </button>
                <button class="nav-item" data-view="view-directory">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span data-i18n="menu_directory">Diretório</span>
                </button>
                <button class="nav-item" data-view="view-insert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span data-i18n="menu_add">Adicionar Operador</span>
                </button>
            </nav>

            <div class="sidebar-footer">
                <div class="nav-section" data-i18n="nav_system">Sistema</div>
                <button class="nav-item" data-view="view-settings">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span data-i18n="menu_settings">Diagnóstico</span>
                </button>
            </div>
        </aside>

        <main class="main-content">
            
            <section id="view-dashboard" class="view-section active">
                <header class="content-header flex-between">
                    <div>
                        <h2 data-i18n="overview_title">Visão Geral do Núcleo</h2>
                        <p class="header-subtitle" data-i18n="overview_sub">Monitoramento de dados em tempo real.</p>
                    </div>
                    <div class="badge-status"><span class="dot-pulse"></span> <span data-i18n="sys_online">SISTEMA ONLINE</span></div>
                </header>

                <div class="metrics-grid">
                    <div class="metric-card bionic-card">
                        <span class="metric-label" data-i18n="stat_volume">VOLUME DE DADOS</span>
                        <span class="metric-value"><?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
                        <div class="metric-footer text-success" data-i18n="stat_stable">↑ Crescimento Estável</div>
                    </div>
                    <div class="metric-card bionic-card">
                        <span class="metric-label" data-i18n="stat_integrity">INTEGRIDADE (DB)</span>
                        <span class="metric-value">100<span style="color:var(--text-muted)">%</span></span>
                        <div class="metric-footer text-muted" data-i18n="stat_no_corruption">Zero corrupções detectadas</div>
                    </div>
                    <div class="metric-card bionic-card">
                        <span class="metric-label" data-i18n="stat_latency">LATÊNCIA MÉDIA</span>
                        <span class="metric-value">12<span style="color:var(--text-muted)">ms</span></span>
                        <div class="metric-footer text-success" data-i18n="stat_optimized">Otimização máxima</div>
                    </div>
                </div>

                <div class="bionic-card heatmap-section">
                    <h3 data-i18n="heatmap_title">Frequência de Registro (Últimos 90 Dias)</h3>
                    <div class="heatmap-grid">
                        <?php for($i=0; $i<114; $i++): $lv = rand(0, 4); ?>
                            <div class="heat-box level-<?= $lv ?>"></div>
                        <?php endfor; ?>
                    </div>
                    <div class="heatmap-legend">
                        <span data-i18n="heat_less">Menos</span>
                        <div class="heat-box level-0"></div><div class="heat-box level-1"></div>
                        <div class="heat-box level-2"></div><div class="heat-box level-3"></div><div class="heat-box level-4"></div>
                        <span data-i18n="heat_more">Mais</span>
                    </div>
                </div>
            </section>

            <section id="view-directory" class="view-section">
                <header class="content-header flex-between">
                    <div>
                        <h2 data-i18n="dir_title">Diretório Central</h2>
                        <p class="header-subtitle" data-i18n="dir_sub">Gerenciamento de operadores e credenciais.</p>
                    </div>
                    <button class="btn-primary" id="btn-shortcut-add" data-i18n="btn_new">+ Novo Registro</button>
                </header>

                <div class="bionic-card table-container">
                    <div class="table-toolbar">
                        <div class="search-input-wrapper">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="tableSearch" placeholder="Pesquisar operador ou e-mail..." data-i18n-placeholder="search_placeholder">
                        </div>
                    </div>
                    <table class="enterprise-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th data-i18n="th_name">OPERADOR</th>
                                <th data-i18n="th_email">CONTATO</th>
                                <th data-i18n="th_course">VÍNCULO</th>
                                <th class="text-right" data-i18n="th_actions">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr class="table-row">
                                    <td class="cell-id">UID-<?= str_pad($user["id"], 4, '0', STR_PAD_LEFT) ?></td>
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
                <header class="content-header"><h2 data-i18n="add_title">Novo Protocolo</h2></header>
                <div class="bionic-card form-card">
                    <form action="store.php" method="post" class="enterprise-form">
                        <div class="form-grid">
                            <div class="input-block">
                                <label data-i18n="label_name">Nome Completo</label>
                                <input type="text" name="name" required placeholder="...">
                            </div>
                            <div class="input-block">
                                <label data-i18n="label_email">E-mail de Contato</label>
                                <input type="email" name="email" required placeholder="...">
                            </div>
                        </div>
                        <div class="input-block" style="margin-top: 20px;">
                            <label data-i18n="label_course">Chave do Curso</label>
                            <input type="text" name="document" required placeholder="...">
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn-primary w-full" data-i18n="btn_save">Finalizar Cadastro</button>
                        </div>
                    </form>
                </div>
            </section>

            <section id="view-settings" class="view-section">
                <header class="content-header">
                    <h2 data-i18n="settings_title">Diagnóstico do Servidor</h2>
                    <p class="header-subtitle" data-i18n="settings_subtitle">Gerenciamento de ambiente, tradução e temas.</p>
                </header>

                <div class="metrics-grid" style="grid-template-columns: 1fr 1fr; grid-template-rows: auto auto;">
                    
                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;" data-i18n="diag_db_title">Conexão com Banco</h3>
                            <span class="badge-status" style="border-color: var(--success); color: var(--success);">ESTÁVEL</span>
                        </div>
                        <ul class="settings-list">
                            <li><span data-i18n="diag_driver">Driver Utilizado</span> <strong>PDO (MySQL)</strong></li>
                            <li><span>Host</span> <strong>localhost</strong></li>
                            <li><span>Database</span> <strong>aula01</strong></li>
                        </ul>
                    </div>

                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;" data-i18n="diag_sec_title">Segurança da Aplicação</h3>
                            <span class="badge-status" style="border-color: var(--success); color: var(--success);" data-i18n="diag_protected">PROTEGIDO</span>
                        </div>
                        <ul class="settings-list">
                            <li><span data-i18n="diag_xss">Prevenção XSS</span> <strong data-i18n="diag_active">Ativa</strong></li>
                            <li><span data-i18n="diag_sql">SQL Injection</span> <strong data-i18n="diag_active">Bloqueado</strong></li>
                        </ul>
                    </div>

                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;" data-i18n="pref_visual">Interface e Temas</h3>
                        </div>
                        <div class="setting-item" style="margin-bottom: 15px;">
                            <label data-i18n="label_theme">Tema do Sistema</label>
                            <select id="theme-selector" class="neo-select">
                                <option value="dark" data-i18n="opt_dark">Dark OLED</option>
                                <option value="light" data-i18n="opt_light">Light Minimalist</option>
                            </select>
                        </div>
                    </div>

                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;" data-i18n="label_lang">Idioma</h3>
                        </div>
                        <div class="setting-item">
                            <select id="lang-selector" class="neo-select">
                                <option value="pt">Português (BR)</option>
                                <option value="en">English (US)</option>
                                <option value="es">Español (ES)</option>
                            </select>
                        </div>
                    </div>

                </div>
            </section>
        </main>
    </div>

    <div id="toast" class="toast-notification"><span id="toast-msg"></span></div>

    <div class="dialog-overlay" id="deleteModal">
        <div class="bionic-card dialog-box">
            <div class="dialog-header"><h3 data-i18n="modal_confirm">Excluir Registro</h3></div>
            <div class="dialog-content"><p data-i18n="modal_text">O registro será purgado permanentemente.</p></div>
            <div class="dialog-footer">
                <button class="btn-secondary" id="btnCancelDelete" data-i18n="btn_cancel">Cancelar</button>
                <button class="btn-danger" id="btnConfirmDelete" data-i18n="btn_del_confirm">Confirmar</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>