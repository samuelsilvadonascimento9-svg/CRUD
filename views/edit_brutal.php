<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Editar Registro Brutal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@500;800;900&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/brutal.css">
</head>
<body>

    <div class="marquee-container">
        <div class="marquee-content">
            <span>MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • </span>
            <span>MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • MODO DE EDIÇÃO ATIVADO • CUIDADO AO ALTERAR DADOS • </span>
        </div>
    </div>

    <div class="main-wrapper" style="display: flex; justify-content: center; min-height: 80vh; align-items: center; padding-bottom: 50px;">
        
        <div class="neo-box pink-shadow" style="width: 100%; max-width: 600px;">
            <div class="box-title">
                <h2>MODIFICAR MATRIZ</h2>
                <span class="mono-badge">ID: #<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span>
            </div>

            <form action="update.php" method="post" enctype="multipart/form-data" class="brutalist-form">
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
                    <label>CPF</label>
                    <input type="text" name="cpf" id="editCpf" value="<?= htmlspecialchars($user["cpf"] ?? '') ?>" required>
                </div>

                <div class="input-block">
                    <label>CELULAR</label>
                    <input type="text" name="phone" id="editPhone" value="<?= htmlspecialchars($user["phone"] ?? '') ?>" required>
                </div>

                <div class="input-block">
                    <label>CURSO VINCULADO</label>
                    <select name="document" class="brutal-select" required>
                        <?php
                        $cursos = [
                            'Engenharia de Computação' => 'ENGENHARIA DE COMP.',
                            'Ciência da Computação' => 'CIÊNCIA DA COMP.',
                            'Sistemas de Informação' => 'SISTEMAS DE INFO.',
                            'Segurança da Informação' => 'SEGURANÇA DA INFO.'
                        ];
                        foreach($cursos as $db_val => $display_val) {
                            $selected = ($user['document'] == $db_val) ? 'selected' : '';
                            echo "<option value=\"$db_val\" $selected>$display_val</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-block">
                    <label>ATUALIZAR FOTO DE PERFIL (OPCIONAL)</label>
                    <input type="file" name="avatar" accept="image/png, image/jpeg, image/webp" class="brutal-select" style="padding: 10px;">
                </div>

                <div class="modal-buttons" style="margin-top: 1rem;">
                    <a href="index.php" class="neo-btn white-btn" style="flex: 1; text-align: center; text-decoration: none;">ABORTAR</a>
                    <button type="submit" class="neo-btn green-btn" style="flex: 1;">SALVAR DADOS</button>
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