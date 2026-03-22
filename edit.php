<?php
require __DIR__ . "/connect.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) die("ID inválido.");

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$user = $stmt->fetch();

if (!$user) die("Registro não encontrado.");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OMNI // Editor de Registro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; background-color: var(--bg-app); }
        .edit-container { width: 100%; max-width: 500px; animation: fadeSlide 0.4s ease-out; }
    </style>
</head>
<body>

    <div class="edit-container">
        <header class="content-header" style="margin-bottom: 20px;">
            <p class="header-subtitle" style="font-family: 'JetBrains Mono', monospace; margin-bottom: 8px; color: var(--text-secondary);">
                REGISTRO: UID-<?= str_pad($user["id"], 4, '0', STR_PAD_LEFT) ?>
            </p>
            <h2 style="font-size: 1.5rem;">Reconfigurar Dados</h2>
        </header>

        <div class="bionic-card form-card" style="padding: 32px; background: var(--bg-element);">
            <form action="update.php" method="post" class="enterprise-form" onsubmit="showToast('Atualizando...')">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">

                <div class="input-block">
                    <label>Nome Completo do Operador</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                </div>

                <div class="input-block">
                    <label>E-mail de Contato</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                </div>

                <div class="input-block">
                    <label>Vínculo Institucional</label>
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required>
                </div>

                <div class="form-footer" style="display: flex; gap: 12px; margin-top: 15px;">
                    <a href="index.php" class="btn-secondary" style="flex: 1; text-align: center; text-decoration: none;">Abortar Modificação</a>
                    <button type="submit" class="btn-primary" style="flex: 1;">Subscrever Dados</button>
                </div>
            </form>
        </div>
    </div>

    <div id="toast" class="toast-notification">
        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        <span id="toast-msg"></span>
    </div>

    <script src="script.js"></script>
</body>
</html>