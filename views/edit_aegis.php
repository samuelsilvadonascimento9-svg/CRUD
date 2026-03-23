<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Modify Entity</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Rajdhani:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/aegis.css">
</head>
<body class="dark-theme">

    <div class="crt-scanlines"></div>

    <div class="hud-wrapper" style="justify-content: center; align-items: center;">
        
        <div class="tactical-box" style="width: 100%; max-width: 600px;">
            <div class="box-corner tl"></div><div class="box-corner tr"></div><div class="box-corner bl"></div><div class="box-corner br"></div>
            
            <div style="border-bottom: 1px solid var(--dark-green); padding-bottom: 10px; margin-bottom: 20px;">
                <span class="text-dim">TARGET_UID: ><?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span>
                <h2 class="text-white" style="font-family: 'Rajdhani', sans-serif; font-size: 2rem;">// MODIFICAR DADOS DA ENTIDADE</h2>
            </div>
            
            <form action="update.php" method="post" enctype="multipart/form-data" class="aegis-form" style="max-width: 100%;">
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

                <div style="display: flex; gap: 15px;">
                    <div class="hud-input-group" style="flex: 1;">
                        <label>> CPF</label>
                        <input type="text" name="cpf" id="editCpf" value="<?= htmlspecialchars($user["cpf"] ?? '') ?>" required autocomplete="off">
                        <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                    </div>
                    <div class="hud-input-group" style="flex: 1;">
                        <label>> CELULAR</label>
                        <input type="text" name="phone" id="editPhone" value="<?= htmlspecialchars($user["phone"] ?? '') ?>" required autocomplete="off">
                        <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                    </div>
                </div>

                <div class="hud-input-group">
                    <label>> CHAVE_VETOR (CURSO)</label>
                    <select name="document" class="hud-select" required>
                        <?php
                        $cursos = ['Engenharia de Computação', 'Ciência da Computação', 'Sistemas de Informação', 'Segurança da Informação'];
                        foreach($cursos as $c) {
                            $selected = ($user['document'] == $c) ? 'selected' : '';
                            $label = strtoupper(str_replace(' ', '_', $c));
                            echo "<option value=\"$c\" $selected>$label</option>";
                        }
                        ?>
                    </select>
                    <div class="crosshair ch-tl"></div><div class="crosshair ch-br"></div>
                </div>

                <div class="hud-input-group">
                    <label>> SCAN_BIOMETRICO_NOVO (FOTO OPCIONAL)</label>
                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp" class="hud-select" style="padding: 9px;">
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

    <script>
        document.getElementById('editCpf').addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/(\d{3})(\d)/, '$1.$2'); v = v.replace(/(\d{3})(\d)/, '$1.$2'); v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = v.substring(0, 14);
        });
        document.getElementById('editPhone').addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, '');
            v = v.replace(/^(\d{2})(\d)/g, '($1) $2'); v = v.replace(/(\d)(\d{4})$/, '$1-$2');
            e.target.value = v.substring(0, 15);
        });
    </script>
</body>
</html>