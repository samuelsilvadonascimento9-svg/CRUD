<?php
require __DIR__ . "/connect.php";
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
if (!$id) die("ID inválido.");

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
$stmt->execute([":id" => $id]);
$user = $stmt->fetch();

if (!$user) die("Aluno não encontrado.");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS // Modificar Registro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="ambient-background">
        <div class="aurora aurora-1"></div>
        <div class="aurora aurora-2"></div>
    </div>

    <div class="edit-wrapper fade-in">
        <div class="glass-card edit-card">
            
            <div class="card-header" style="margin-bottom: 2rem;">
                <div class="mono-text text-accent" style="font-size: 0.8rem; margin-bottom: 10px; letter-spacing: 2px;">
                    TARGET_UID: #<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?>
                </div>
                <h2 style="font-size: 1.5rem; font-weight: 600;">RECONFIGURAR MATRIZ</h2>
                <p class="text-dim" style="font-size: 0.9rem;">Modificação de credenciais de acesso</p>
            </div>

            <form action="update.php" method="post" class="neo-form">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">

                <div class="form-group">
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required placeholder=" ">
                    <label>NOME DO OPERADOR</label>
                    <div class="focus-border"></div>
                </div>

                <div class="form-group">
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required placeholder=" ">
                    <label>ENDEREÇO DE E-MAIL</label>
                    <div class="focus-border"></div>
                </div>

                <div class="form-group">
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required placeholder=" ">
                    <label>CHAVE DO CURSO</label>
                    <div class="focus-border"></div>
                </div>

                <div class="form-actions">
                    <a href="index.php" class="btn-ghost hover-magnetic">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        ABORTAR
                    </a>
                    <button type="submit" class="btn-glow hover-magnetic">
                        SINCRONIZAR 
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </button>
                </div>
            </form>
            
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>