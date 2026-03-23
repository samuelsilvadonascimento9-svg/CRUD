<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Brutalista</title>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@500;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/brutal.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartLabels = <?= $chartLabels ?? '[]' ?>;
        const chartData = <?= $chartData ?? '[]' ?>;
        const serverToastSuccess = "<?= $toast_success ?? '' ?>";
        const serverToastError = "<?= $toast_error ?? '' ?>";
    </script>

    <style>
        th.sortable { cursor: pointer; transition: 0.2s; user-select: none; }
        th.sortable:hover { background-color: #000; color: #FFF; }
        
        /* FIX PARA OS CAMPOS NÃO VAZAREM (Resolução do seu bug visual) */
        .brutalist-form .input-block input, 
        .brutalist-form .input-block select {
            width: 100% !important;
            box-sizing: border-box !important;
        }

        /* AJUSTES DA CÂMERA (PANNING) */
        .canvas-viewport {
            overflow: hidden; 
            width: 100%; 
            position: relative;
            padding-bottom: 50px;
        }
        .canvas-pan {
            display: flex; 
            width: 300%; 
            transform: translateX(-33.333%); 
            transition: transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .canvas-panel {
            width: 33.333%; 
            padding: 0 20px;
            box-sizing: border-box;
        }
    </style>
</head>
<body>

    <div class="marquee-container">
        <div class="marquee-content">
            <span>SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • SISTEMA DE GESTÃO MATRICULAR • </span>
            <span>SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • SISTEMA DE GESTÃO MATRICULAR • </span>
        </div>
    </div>

    <div class="main-wrapper">
        <header class="neo-header neo-box" style="margin-bottom: 2rem;">
            <div class="brand-block">
                <div class="black-square"></div>
                <h1>PORTAL ACADÊMICO</h1>
            </div>
            <div class="stats-block"><span class="mono-badge yellow-bg">REGISTROS: <?= str_pad(count($users), 3, '0', STR_PAD_LEFT) ?></span></div>
        </header>

        <div class="canvas-viewport">
            <div class="canvas-pan" id="canvasPan">

                <div class="canvas-panel">
                    <button class="neo-btn white-btn btn-go-center" style="margin-bottom: 20px;">
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        VOLTAR PARA MATRIZ
                    </button>
                    
                    <aside class="neo-box form-box pink-shadow" style="max-width: 600px; margin: 0 auto;">
                        <div class="box-title">
                            <h2 data-i18n="add_title">ENTRADA</h2><span class="mono-badge">NOVO</span>
                        </div>
                        <form action="store.php" method="post" enctype="multipart/form-data" class="brutalist-form">
                            <div class="input-block">
                                <label data-i18n="label_name">NOME DO OPERADOR</label>
                                <input type="text" name="name" required placeholder="...">
                            </div>
                            <div class="input-block">
                                <label data-i18n="label_email">E-MAIL DE CONTATO</label>
                                <input type="email" name="email" required placeholder="...">
                            </div>
                            <div class="input-block">
                                <label>CPF</label>
                                <input type="text" name="cpf" id="cpfMask" required placeholder="000.000.000-00">
                            </div>
                            <div class="input-block">
                                <label>CELULAR</label>
                                <input type="text" name="phone" id="phoneMask" required placeholder="(00) 00000-0000">
                            </div>
                            <div class="input-block">
                                <label data-i18n="label_course">CURSO VINCULADO</label>
                                <select name="document" class="brutal-select" required>
                                    <option value="" disabled selected>ESCOLHA UMA OPÇÃO...</option>
                                    <option value="Engenharia de Computação">ENGENHARIA DE COMP.</option>
                                    <option value="Ciência da Computação">CIÊNCIA DA COMP.</option>
                                    <option value="Sistemas de Informação">SISTEMAS DE INFO.</option>
                                    <option value="Segurança da Informação">SEGURANÇA DA INFO.</option>
                                </select>
                            </div>
                            <div class="input-block">
                                <label>FOTO DE PERFIL (OPCIONAL)</label>
                                <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp" class="brutal-select" style="padding: 10px;">
                            </div>
                            <button type="submit" class="neo-btn green-btn" style="margin-top: 15px; width: 100%;">
                                <span data-i18n="btn_save">CADASTRAR DADOS</span>
                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>
                        </form>
                    </aside>
                </div>

                <div class="canvas-panel" style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="display: flex; justify-content: space-between; gap: 20px;">
                        <button class="neo-btn pink-btn" id="btnGoLeft" style="flex: 1; justify-content: center;">
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span style="margin-left: 10px;">NOVO CADASTRO</span>
                        </button>
                        <button class="neo-btn blue-btn" id="btnGoRight" style="flex: 1; justify-content: center;">
                            <span style="margin-right: 10px;">CONFIGURAÇÕES</span>
                            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        </button>
                    </div>

                    <div style="display: flex; gap: 20px; align-items: stretch;">
                        <aside class="neo-box yellow-shadow" style="background: #FFF; width: 350px; flex-shrink: 0;">
                            <div class="box-title" style="border-bottom: 3px solid #000; margin-bottom: 10px;"><h2>ESTATÍSTICAS</h2></div>
                            <div style="width: 100%; display: flex; justify-content: center;"><canvas id="courseChart" style="max-height: 200px;"></canvas></div>
                        </aside>
                        
                        <div class="neo-box green-shadow" style="flex: 1; display: flex; flex-direction: column; justify-content: center; background: #FFF;">
                            <h2 style="margin-bottom: 10px;">LOCALIZAR REGISTRO</h2>
                            <div style="display: flex; gap: 10px;">
                                <input type="text" id="tableSearch" placeholder="BUSCAR POR NOME, CPF, CURSO..." style="flex: 1; border: 3px solid #000; padding: 15px; font-family: 'Space Mono', monospace; font-size: 1.1rem; font-weight: bold; box-shadow: 4px 4px 0 #000;">
                                <a href="export.php" class="neo-btn blue-btn" style="text-decoration: none; padding: 15px; display: flex; align-items: center;">📥 .CSV</a>
                            </div>
                        </div>
                    </div>

                    <main class="neo-box table-box" style="flex: 1;">
                        <div class="box-title" style="border-bottom: 3px solid #000; padding-bottom: 1rem; margin-bottom: 1rem;">
                            <h2 data-i18n="dir_title">MATRIZ DE USUÁRIOS</h2>
                        </div>
                        <div class="table-scroll">
                            <table class="neo-table">
                                <thead>
                                    <tr>
                                        <th>FOTO</th>
                                        <th class="sortable">ID ↕</th>
                                        <th class="sortable" data-i18n="th_name">OPERADOR ↕</th>
                                        <th class="sortable" data-i18n="th_course">CURSO ↕</th>
                                        <th data-i18n="th_cmd">AÇÕES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr class="table-row">
                                            <td style="width: 70px;">
                                                <img src="uploads/avatars/<?= htmlspecialchars($user['avatar'] ?? 'default.png') ?>" alt="Avatar" style="width: 50px; height: 50px; object-fit: cover; border: 3px solid #000; box-shadow: 2px 2px 0 #000;">
                                            </td>
                                            <td class="font-mono"><strong>#<?= $user["id"] ?></strong></td>
                                            <td>
                                                <div class="heavy-text highlight-target" style="font-size: 1.1rem; line-height: 1.2;"><?= htmlspecialchars($user["name"]) ?></div>
                                                <div class="font-mono" style="font-size: 0.8rem; margin-top: 5px; color: #333;">
                                                    <?= htmlspecialchars($user["email"]) ?> <br> <?= htmlspecialchars($user["phone"] ?? '') ?>
                                                </div>
                                            </td>
                                            <td><span class="neo-tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="edit.php?id=<?= $user["id"] ?>" class="neo-icon-btn yellow-bg" title="Editar">✏️</a>
                                                    <button data-href="delete.php?id=<?= $user["id"] ?>" class="neo-icon-btn red-bg custom-delete-btn" title="Excluir">🗑️</button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </main>
                </div>

                <div class="canvas-panel">
                    <button class="neo-btn white-btn btn-go-center" style="margin-bottom: 20px;">
                        VOLTAR PARA MATRIZ
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none" style="margin-left: 10px;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>

                    <aside class="neo-box blue-shadow" style="max-width: 600px; margin: 0 auto;">
                        <div class="box-title"><h2 data-i18n="settings_title">CONFIGS</h2></div>
                        <div class="brutalist-form">
                            <div class="input-block">
                                <label data-i18n="lang_select">IDIOMA</label>
                                <select id="lang-selector" class="brutal-select">
                                    <option value="pt">PORTUGUÊS (BR)</option>
                                    <option value="en">ENGLISH (US)</option>
                                    <option value="es">ESPAÑOL (ES)</option>
                                </select>
                            </div>
                            <div class="input-block">
                                <label data-i18n="layout_select">ARQUITETURA</label>
                                <select id="layout-selector" class="brutal-select yellow-bg">
                                    <option value="brutal">Layout Pôster (Brutalista)</option>
                                    <option value="omni">Layout Corporativo (Clássico)</option>
                                    <option value="aegis">Layout Tático (Hacker)</option>
                                    <option value="quantum">Layout Espacial (Transparente)</option>
                                </select>
                            </div>
                            <a href="logout.php" class="neo-btn white-btn" style="margin-top: 20px; text-decoration: none; display: block; text-align: center; color: red; border-color: red;">ENCERRAR SESSÃO</a>
                        </div>
                    </aside>
                </div>

            </div>
        </div>
    </div>

    <div id="brutal-toast" style="position: fixed; bottom: -100px; right: 30px; border: 4px solid #000; padding: 20px 30px; font-family: 'Epilogue', sans-serif; font-weight: 900; background: #FFF; transition: 0.3s; z-index: 9999; box-shadow: 6px 6px 0 #000;"><span id="brutal-toast-msg"></span></div>

    <div class="neo-modal-overlay" id="deleteModal">
        <div class="neo-box modal-content red-shadow">
            <h2 data-i18n="modal_title">AVISO CRÍTICO</h2>
            <p data-i18n="modal_text">Enviar este operador para a lixeira do sistema?</p>
            <div class="modal-buttons">
                <button class="neo-btn white-btn" id="btnCancelDelete" data-i18n="btn_abort">CANCELAR</button>
                <button class="neo-btn red-btn" id="btnConfirmDelete" data-i18n="btn_confirm">CONFIRMAR</button>
            </div>
        </div>
    </div>

    <script src="assets/js/brutal.js"></script>
</body>
</html>