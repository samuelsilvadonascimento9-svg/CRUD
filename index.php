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
    <title>SISTEMA // Neo-Brutalist</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@500;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="marquee-container">
        <div class="marquee-content">
            <span>SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • </span>
            <span>SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • SISTEMA DE GESTÃO MATRICULAR • BASE DE DADOS ONLINE • CRUD OPERATIONS • </span>
        </div>
    </div>

    <div class="main-wrapper">
        
        <header class="neo-header neo-box">
            <div class="brand-block">
                <div class="black-square"></div>
                <h1>DATA.BASE</h1>
            </div>
            <div class="stats-block">
                <span class="mono-badge yellow-bg">REGISTROS: <?= str_pad(count($users), 3, '0', STR_PAD_LEFT) ?></span>
            </div>
        </header>

        <div class="grid-layout">
            
            <aside class="neo-box form-box pink-shadow">
                <div class="box-title">
                    <h2>ENTRADA</h2>
                    <span class="mono-badge">NOVO</span>
                </div>
                
                <form action="store.php" method="post" class="brutalist-form">
                    <div class="input-block">
                        <label>NOME DO OPERADOR</label>
                        <input type="text" name="name" required placeholder="Digite o nome...">
                    </div>

                    <div class="input-block">
                        <label>E-MAIL DE CONTATO</label>
                        <input type="email" name="email" required placeholder="exemplo@mail.com">
                    </div>

                    <div class="input-block">
                        <label>CURSO VINCULADO</label>
                        <input type="text" name="document" required placeholder="Sigla do curso...">
                    </div>

                    <button type="submit" class="neo-btn green-btn">
                        CADASTRAR DADOS 
                        <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="3" fill="none"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </form>
            </aside>

            <main class="neo-box table-box blue-shadow">
                <div class="box-title">
                    <h2>MATRIZ DE USUÁRIOS</h2>
                </div>
                
                <div class="table-scroll">
                    <table class="neo-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>OPERADOR</th>
                                <th>E-MAIL</th>
                                <th>CURSO</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr>
                                    <td class="font-mono"><strong>#<?= $user["id"] ?></strong></td>
                                    <td class="heavy-text"><?= htmlspecialchars($user["name"]) ?></td>
                                    <td><?= htmlspecialchars($user["email"]) ?></td>
                                    <td><span class="neo-tag"><?= htmlspecialchars($user["document"]) ?></span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="edit.php?id=<?= $user["id"] ?>" class="neo-icon-btn yellow-bg" title="Editar">
                                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            </a>
                                            <a href="delete.php?id=<?= $user["id"] ?>" class="neo-icon-btn red-bg custom-delete-btn" title="Excluir">
                                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </main>

        </div>
    </div>

    <div class="neo-modal-overlay" id="deleteModal">
        <div class="neo-box modal-content red-shadow">
            <h2>AVISO CRÍTICO</h2>
            <p>Você tem certeza que deseja excluir este operador da base de dados? Isso não pode ser desfeito.</p>
            <div class="modal-buttons">
                <button class="neo-btn white-btn" id="btnCancelDelete">CANCELAR</button>
                <button class="neo-btn red-btn" id="btnConfirmDelete">EXCLUIR</button>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>