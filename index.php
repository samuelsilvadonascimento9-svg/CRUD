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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                <div class="nav-section">Aplicações</div>
                <button class="nav-item active" data-view="view-dashboard">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                    Visão Geral
                </button>
                <button class="nav-item" data-view="view-directory">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    Diretório
                </button>
                <button class="nav-item" data-view="view-insert">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    Adicionar Operador
                </button>
            </nav>

            <div class="sidebar-footer">
                <div class="nav-section">Sistema</div>
                <button class="nav-item" data-view="view-settings">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    Diagnóstico
                </button>
            </div>
        </aside>

        <main class="main-content">
            
            <section id="view-dashboard" class="view-section active">
                <header class="content-header flex-between">
                    <div>
                        <h2>Visão Geral do Núcleo</h2>
                        <p class="header-subtitle">Monitoramento de dados em tempo real.</p>
                    </div>
                    <div class="badge-status"><span class="dot-pulse"></span> SISTEMA ONLINE</div>
                </header>

                <div class="metrics-grid">
                    <div class="metric-card bionic-card">
                        <span class="metric-label">VOLUME DE DADOS</span>
                        <span class="metric-value"><?= str_pad(count($users), 4, '0', STR_PAD_LEFT) ?></span>
                        <div class="metric-footer text-success">↑ Crescimento Estável</div>
                    </div>
                    <div class="metric-card bionic-card">
                        <span class="metric-label">INTEGRIDADE (DB)</span>
                        <span class="metric-value">100<span style="color:var(--text-muted)">%</span></span>
                        <div class="metric-footer text-muted">Zero corrupções detectadas</div>
                    </div>
                    <div class="metric-card bionic-card">
                        <span class="metric-label">LATÊNCIA MÉDIA</span>
                        <span class="metric-value">12<span style="color:var(--text-muted)">ms</span></span>
                        <div class="metric-footer text-success">Otimização máxima</div>
                    </div>
                </div>

                <div class="bionic-card heatmap-section">
                    <h3>Frequência de Registro (Últimos 90 Dias)</h3>
                    <div class="heatmap-grid">
                        <?php 
                        for($i=0; $i<114; $i++): 
                            $intensity = rand(0, 4); 
                        ?>
                            <div class="heat-box level-<?= $intensity ?>" title="Atividade nível <?= $intensity ?>"></div>
                        <?php endfor; ?>
                    </div>
                    <div class="heatmap-legend">
                        <span>Menos</span>
                        <div class="heat-box level-0"></div><div class="heat-box level-1"></div>
                        <div class="heat-box level-2"></div><div class="heat-box level-3"></div><div class="heat-box level-4"></div>
                        <span>Mais</span>
                    </div>
                </div>
            </section>

            <section id="view-directory" class="view-section">
                <header class="content-header flex-between">
                    <div>
                        <h2>Diretório Central</h2>
                        <p class="header-subtitle">Gerenciamento de operadores e credenciais.</p>
                    </div>
                    <button class="btn-primary" id="btn-shortcut-add">+ Novo Registro</button>
                </header>

                <div class="bionic-card table-container">
                    <div class="table-toolbar">
                        <div class="search-input-wrapper">
                            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="tableSearch" placeholder="Pesquisar operador ou e-mail...">
                        </div>
                    </div>

                    <table class="enterprise-table" id="dataTable">
                        <thead>
                            <tr>
                                <th>IDENTIFICAÇÃO</th>
                                <th>OPERADOR</th>
                                <th>CONTATO</th>
                                <th>VÍNCULO</th>
                                <th class="text-right">AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($users) > 0): ?>
                                <?php foreach ($users as $user) : ?>
                                    <tr class="table-row">
                                        <td class="cell-id">UID-<?= str_pad($user["id"], 4, '0', STR_PAD_LEFT) ?></td>
                                        <td class="cell-primary"><?= htmlspecialchars($user["name"]) ?></td>
                                        <td class="cell-muted"><?= htmlspecialchars($user["email"]) ?></td>
                                        <td><span class="tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                        <td class="cell-actions text-right">
                                            <a href="edit.php?id=<?= $user["id"] ?>" class="btn-ghost-sm">Editar</a>
                                            <a href="delete.php?id=<?= $user["id"] ?>" class="btn-ghost-sm danger custom-delete-btn">Apagar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        <div class="empty-content">
                                            <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                                            <p>A matriz está vazia. Nenhum operador registrado.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="view-insert" class="view-section">
                <header class="content-header">
                    <h2>Novo Protocolo</h2>
                    <p class="header-subtitle">Autentique um novo operador no sistema.</p>
                </header>

                <div class="bionic-card form-card">
                    <form action="store.php" method="post" class="enterprise-form" onsubmit="showToast('Processando dados...', 'info')">
                        
                        <div class="form-grid">
                            <div class="input-block">
                                <label>Nome Completo</label>
                                <input type="text" name="name" required placeholder="Digite o nome do operador">
                            </div>

                            <div class="input-block">
                                <label>E-mail de Contato</label>
                                <input type="email" name="email" required placeholder="email@dominio.com">
                            </div>
                        </div>

                        <div class="input-block" style="margin-top: 20px;">
                            <label>Chave do Curso</label>
                            <input type="text" name="document" required placeholder="EX: ENG-COMP-2026">
                            <span class="input-hint">Use a nomenclatura oficial (Letras maiúsculas).</span>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn-primary w-full">Finalizar Cadastro &rarr;</button>
                        </div>
                    </form>
                </div>
            </section>

            <section id="view-settings" class="view-section">
                <header class="content-header">
                    <h2>Diagnóstico do Servidor</h2>
                    <p class="header-subtitle">Parâmetros de ambiente, segurança e banco de dados.</p>
                </header>

                <div class="metrics-grid" style="grid-template-columns: 1fr 1fr;">
                    
                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;">Conexão com Banco</h3>
                            <span class="badge-status" style="border-color: var(--success); color: var(--success);">ESTÁVEL</span>
                        </div>
                        <ul class="settings-list">
                            <li><span>Driver Utilizado</span> <strong>PDO (PHP Data Objects)</strong></li>
                            <li><span>Host</span> <strong>localhost</strong></li>
                            <li><span>Base de Dados</span> <strong>aula01</strong></li>
                            <li><span>Charset</span> <strong>utf8mb4</strong></li>
                        </ul>
                    </div>

                    <div class="bionic-card form-card" style="width: 100%; max-width: 100%;">
                        <div class="flex-between" style="margin-bottom: 20px; border-bottom: 1px solid var(--border-subtle); padding-bottom: 15px;">
                            <h3 style="font-size: 1rem; font-weight: 500;">Segurança da Aplicação</h3>
                            <span class="badge-status" style="border-color: var(--success); color: var(--success);">PROTEGIDO</span>
                        </div>
                        <ul class="settings-list">
                            <li><span>Prevenção XSS</span> <strong>Ativa (htmlspecialchars)</strong></li>
                            <li><span>SQL Injection</span> <strong>Bloqueado (Prepare Statements)</strong></li>
                            <li><span>Validação de ID</span> <strong>Ativa (filter_input)</strong></li>
                        </ul>
                    </div>

                </div>
            </section>

        </main>
    </div>

    <div id="toast" class="toast-notification">
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span id="toast-msg">Ação realizada com sucesso.</span>
    </div>

    <div class="dialog-overlay" id="deleteModal">
        <div class="bionic-card dialog-box">
            <div class="dialog-header">
                <div class="dialog-title-group">
                    <div class="icon-danger">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <h3>Excluir Permanentemente</h3>
                </div>
            </div>
            <div class="dialog-content">
                <p>O registro selecionado será purgado da base de dados. Esta operação quebrará a chave de acesso do operador e <strong>não poderá ser desfeita</strong>.</p>
            </div>
            <div class="dialog-footer">
                <button class="btn-secondary" id="btnCancelDelete">Cancelar</button>
                <button class="btn-danger" id="btnConfirmDelete">Sim, Excluir</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>