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
    <title>AURA // Modificar Operador</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Outfit:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>

    <div class="bg-mesh">
        <div class="glow-orb orb-amber"></div>
        <div class="glow-orb orb-pink"></div>
    </div>
    <div class="bg-grid"></div>

    <div class="bento-container fade-in" style="min-height: 100vh; display: flex; align-items: center; justify-content: center;">
        
        <section class="bento-item" style="width: 100%; max-width: 500px;">
            <div class="module-title">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                RECONFIGURAÇÃO DE MATRIZ
            </div>
            
            <div class="mono-text text-amber" style="margin-bottom: 2rem; font-size: 0.8rem; border-bottom: 1px solid var(--bento-border); padding-bottom: 10px;">
                TARGET_UID: #<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?>
            </div>

            <form action="update.php" method="post" class="aura-form">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">

                <div class="input-box">
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required placeholder=" ">
                    <label>NOME DO OPERADOR</label>
                    <div class="input-border"></div>
                </div>

                <div class="input-box">
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required placeholder=" ">
                    <label>ENDEREÇO DE E-MAIL</label>
                    <div class="input-border"></div>
                </div>

                <div class="input-box">
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required placeholder=" ">
                    <label>CHAVE DE ACESSO / CURSO</label>
                    <div class="input-border"></div>
                </div>

                <div class="form-row" style="margin-top: 1rem;">
                    <a href="index.php" class="btn-secondary hover-magnetic" style="display:flex; justify-content:center; align-items:center; text-decoration:none; padding:1rem; border-radius:12px; font-weight:700;">
                        ABORTAR
                    </a>
                    <button type="submit" class="btn-premium hover-magnetic">
                        SINCRONIZAR
                    </button>
                </div>
            </form>
        </section>

    </div>

    <script src="script.js"></script>
</body>
</html>