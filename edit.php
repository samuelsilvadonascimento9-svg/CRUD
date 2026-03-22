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
    <title>SISTEMA // Editar Registro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@500;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="marquee-container">
        <div class="marquee-content">
            <span>MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • </span>
            <span>MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • </span>
        </div>
    </div>

    <div class="main-wrapper" style="display: flex; justify-content: center; min-height: 80vh; align-items: center;">
        
        <div class="neo-box pink-shadow" style="width: 100%; max-width: 600px;">
            <div class="box-title">
                <h2>MODIFICAR MATRIZ</h2>
                <span class="mono-badge">ID: #<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span>
            </div>

            <form action="update.php" method="post" class="brutalist-form">
                <input type="hidden" name="id" value="<?= $user["id"] ?>">

                <div class="input-block">
                    <label>NOME DO OPERADOR</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                </div>

                <div class="input-block">
                    <label>E-MAIL DE CONTATO</label>
                    <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                </div>

                <div class="input-block">
                    <label>CURSO VINCULADO</label>
                    <input type="text" name="document" value="<?= htmlspecialchars($user["document"]) ?>" required>
                </div>

                <div class="modal-buttons" style="margin-top: 1rem;">
                    <a href="index.php" class="neo-btn white-btn" style="flex: 1; text-align: center;">ABORTAR</a>
                    <button type="submit" class="neo-btn green-btn" style="flex: 1;">SALVAR DADOS</button>
                </div>
            </form>
        </div>

    </div>

    <script src="script.js"></script>
</body>
</html>