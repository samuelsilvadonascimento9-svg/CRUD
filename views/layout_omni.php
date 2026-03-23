<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Omni</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/omni.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        const chartLabels = <?= $chartLabels ?? '[]' ?>;
        const chartData = <?= $chartData ?? '[]' ?>;
        const serverToastSuccess = "<?= $toast_success ?? '' ?>";
        const serverToastError = "<?= $toast_error ?? '' ?>";
    </script>
    
    <style>
        th.sortable { cursor: pointer; transition: color 0.2s, background 0.2s; user-select: none; }
        th.sortable:hover { color: var(--text-primary); background: var(--bg-hover); }

        /* Ajuste do Mapa de Atividade para preencher o card grande */
        .heatmap-container { 
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            padding: 10px;
        }
        .heatmap-grid { 
            display: grid; 
            grid-template-columns: repeat(14, 1fr); 
            gap: 10px; 
            width: 100%;
        }
        .heat-box { 
            width: 100%; 
            aspect-ratio: 1; 
            border-radius: 3px; 
            background: var(--heat-0, #161b22); 
            transition: all 0.2s ease;
            cursor: crosshair;
        }
        .heat-box:hover { 
            transform: scale(1.4); 
            z-index: 10; 
            box-shadow: 0 0 15px var(--success);
            outline: 2px solid #fff;
        }
        .level-0 { background-color: #161b22 !important; }
        .level-1 { background-color: #0e4429 !important; }
        .level-2 { background-color: #006d32 !important; }
        .level-3 { background-color: #26a641 !important; }
        .level-4 { background-color: #39d353 !important; }
    </style>
</head>
<body>
    <div class="app-layout">
        <aside class="sidebar bionic-card">
            <div class="sidebar-header">
                <div class="logo-mark"><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg></div>
                <span class="logo-text">ACADÊMICO.</span>
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
                    <span data-i18n="menu_add">Novo Registro</span>
                </button>
            </nav>
            <div class="sidebar-footer">
                <div class="nav-section" data-i18n="nav_system">Sistema</div>
                <button class="nav-item" data-view="view-settings">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span data-i18n="menu_settings">Configurações</span>
                </button>
                <a href="logout.php" class="nav-item" style="color: var(--danger); text-decoration: none; margin-top: 10px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Sair do Portal</span>
                </a>
            </div>
        </aside>

        <main class="main-content">
            <section id="view-dashboard" class="view-section active">
                <header class="content-header flex-between">
                    <div><h2 data-i18n="overview_title">Visão Geral</h2><p class="header-subtitle">Monitoramento de registros e integridade.</p></div>
                    <div class="badge-status"><span class="dot-pulse"></span> <span data-i18n="sys_online">SISTEMA ATIVO</span></div>
                </header>
                <div class="metrics-grid">
                    <div class="metric-card bionic-card"><span class="metric-label" data-i18n="stat_volume">TOTAL REGISTROS</span><span class="metric-value"><?= str_pad(count($users), 3, '0', STR_PAD_LEFT) ?></span></div>
                    <div class="metric-card bionic-card"><span class="metric-label">INTEGRIDADE</span><span class="metric-value">100%</span></div>
                    <div class="metric-card bionic-card"><span class="metric-label">LATÊNCIA</span><span class="metric-value">07ms</span></div>
                </div>
                <div class="metrics-grid" style="grid-template-columns: 1.2fr 1fr;">
                    <div class="bionic-card heatmap-section">
                        <h3 data-i18n="activity_map" style="margin-bottom: 20px; font-size: 0.9rem; text-transform: uppercase; color: var(--text-secondary);">Densidade de Dados</h3>
                        <div class="heatmap-container">
                            <div class="heatmap-grid">
                                <?php for($i=0;$i<84;$i++){ $lv=rand(0,4); echo "<div class='heat-box level-$lv' title='Densidade Nível $lv'></div>"; } ?>
                            </div>
                        </div>
                    </div>
                    <div class="bionic-card heatmap-section" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                        <h3 style="margin-bottom: 25px; font-size: 0.9rem; text-transform: uppercase; color: var(--text-secondary);">Distribuição de Vetores</h3>
                        <div style="width: 100%; max-width: 220px;">
                            <canvas id="courseChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <section id="view-directory" class="view-section">
                <header class="content-header flex-between">
                    <div><h2 data-i18n="dir_title">Diretório</h2><p class="header-subtitle">Gerenciamento de operadores ativos.</p></div>
                    <a href="export.php" class="btn-primary" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Exportar Relatório
                    </a>
                </header>
                <div class="bionic-card table-container">
                    <div class="table-toolbar">
                        <div class="search-input-wrapper">
                            <input type="text" id="tableSearch" placeholder="Pesquisar registros..." data-i18n-placeholder="search_placeholder">
                        </div>
                    </div>
                    <table class="enterprise-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>FOTO</th>
                                <th class="sortable">UID ↕</th>
                                <th class="sortable" data-i18n="th_name">NOME / CONTATOS ↕</th>
                                <th class="sortable" data-i18n="th_course">CURSO ↕</th>
                                <th class="text-right" data-i18n="th_cmd">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr class="table-row">
                                <td style="width: 60px;">
                                    <img src="uploads/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                </td>
                                <td class="cell-id">#<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></td>
                                <td>
                                    <div class="cell-primary highlight-target"><?= htmlspecialchars($user["name"]) ?></div>
                                    <div class="cell-muted" style="font-size: 0.75rem;">
                                        <?= htmlspecialchars($user["email"]) ?> | <?= htmlspecialchars($user["phone"] ?? '') ?>
                                    </div>
                                </td>
                                <td><span class="tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                <td class="text-right">
                                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                        <a href="edit.php?id=<?= $user["id"] ?>" class="btn-ghost-sm">Editar</a>
                                        <button data-href="delete.php?id=<?= $user["id"] ?>" class="btn-ghost-sm danger custom-delete-trigger">Excluir</button>
                                    </div>
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
                    <form action="store.php" method="post" enctype="multipart/form-data" class="enterprise-form">
                        <div class="form-grid">
                            <div class="input-block"><label>Nome Completo</label><input type="text" name="name" required></div>
                            <div class="input-block"><label>Email Corporativo</label><input type="email" name="email" required></div>
                        </div>
                        <div class="form-grid" style="margin-top:20px">
                            <div class="input-block"><label>CPF</label><input type="text" name="cpf" id="cpfMask" placeholder="000.000.000-00" required></div>
                            <div class="input-block"><label>Celular</label><input type="text" name="phone" id="phoneMask" placeholder="(00) 00000-0000" required></div>
                        </div>
                        <div class="form-grid" style="margin-top:20px">
                            <div class="input-block">
                                <label>Curso Vinculado</label>
                                <select name="document" class="neo-select" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option value="Engenharia de Computação">Engenharia de Computação</option>
                                    <option value="Ciência da Computação">Ciência da Computação</option>
                                    <option value="Sistemas de Informação">Sistemas de Informação</option>
                                    <option value="Segurança da Informação">Segurança da Informação</option>
                                </select>
                            </div>
                            <div class="input-block">
                                <label>Foto de Perfil</label>
                                <input type="file" name="avatar" class="neo-select" accept="image/*">
                            </div>
                        </div>
                        <div class="form-footer" style="margin-top: 30px;"><button type="submit" class="btn-primary w-full">Sincronizar Dados</button></div>
                    </form>
                </div>
            </section>

            <section id="view-settings" class="view-section">
                 <header class="content-header"><h2 data-i18n="settings_title">Configurações</h2></header>
                <div class="metrics-grid" style="grid-template-columns: 1fr 1fr;">
                    <div class="bionic-card form-card">
                        <h3 style="margin-bottom:20px">Preferências Visuais</h3>
                        <div class="setting-item">
                            <label>Esquema de Cores</label>
                            <select id="theme-selector" class="neo-select">
                                <option value="dark">Modo Escuro OLED</option>
                                <option value="light">Modo Claro Minimal</option>
                            </select>
                        </div>
                        <div class="setting-item" style="margin-top:20px">
                            <label>Idioma da Interface</label>
                            <select id="lang-selector" class="neo-select">
                                <option value="pt">Português (BR)</option>
                                <option value="en">English (US)</option>
                                <option value="es">Español (ES)</option>
                            </select>
                        </div>
                        <div class="setting-item" style="margin-top:20px">
                            <label style="color: var(--success);">Arquitetura de Layout</label>
                            <select id="layout-selector" class="neo-select">
                                <option value="omni">Layout Corporativo (Omni)</option>
                                <option value="aegis">Layout Tático (Aegis)</option>
                                <option value="quantum">Layout Espacial (Quantum)</option>
                                <option value="brutal">Layout Pôster (Brutal)</option>
                            </select>
                        </div>
                    </div>
                    <div class="bionic-card form-card">
                        <h3 style="margin-bottom:20px">Status de Integridade</h3>
                        <ul class="settings-list" style="list-style: none; padding: 0;">
                            <li style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border-subtle);"><span>Prevenção XSS</span> <strong style="color:var(--success)">PROTEGIDO</strong></li>
                            <li style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border-subtle);"><span>SQL Injection</span> <strong style="color:var(--success)">BLOQUEADO</strong></li>
                            <li style="display: flex; justify-content: space-between;"><span>Sistema de Lixeira</span> <strong style="color:var(--success)">ATIVO</strong></li>
                        </ul>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <div id="toast" class="toast-notification">
        <span id="toast-msg"></span>
    </div>

    <div class="dialog-overlay" id="deleteModal">
        <div class="bionic-card dialog-box">
            <div class="dialog-header"><h3>Confirmar Lixeira?</h3></div>
            <div class="dialog-content" style="margin-top: 15px; color: var(--text-secondary);"><p>O registro será movido para a lixeira. Ele poderá ser recuperado posteriormente pelo banco de dados.</p></div>
            <div class="dialog-footer">
                <button class="btn-secondary" id="btnCancelDelete">Cancelar</button>
                <button class="btn-danger" id="btnConfirmDelete">Confirmar</button>
            </div>
        </div>
    </div>
    
    <script src="assets/js/omni.js"></script>
</body>
</html>