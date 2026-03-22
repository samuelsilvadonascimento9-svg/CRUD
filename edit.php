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
    <title>AEGIS // Modify Entity</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="crt-scanlines"></div>

    <div class="hud-wrapper" style="justify-content: center; align-items: center;">
        
        <div class="tactical-box" style="width: 100%; max-width: 600px;">
            <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
            
            <div style="border-bottom: 1px solid var(--dark-green); padding-bottom: 10px; margin-bottom: 20px;">
                <span class="text-dim">TARGET_UID: ><?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span>
                <h2 class="text-white" style="font-family: 'Rajdhani', sans-serif; font-size: 2rem;">// MODIFICAR DADOS DA ENTIDADE</h2>
            </div>
            
            <form action="update.php" method="post" class="aegis-form" style="max-width: 100%;">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">

                <div class="hud-input-group">
                    <label>> NOME_DO_OPERADOR</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required autocomplete="off">
                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                </div>

                <div class="hud-input-group">
                    <label>> ENDERECO_SINAL (E-MAIL)</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required autocomplete="off">
                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                </div>

                <div class="hud-input-group">
                    <label>> CHAVE_VETOR (CURSO)</label>
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required autocomplete="off">
                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                </div>

                <div style="display: flex; gap: 15px; margin-top: 20px;">
                    <a href="index.php" class="hud-submit-btn ghost" style="flex: 1; text-align: center; text-decoration: none;">
                        << ABORTAR
                    </a>
                    <button type="submit" class="hud-submit-btn" style="flex: 1;">
                        OVERRIDE_DATA >>
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script src="script.js"></script>
</body>
</html>