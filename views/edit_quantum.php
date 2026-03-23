<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Configuração Espacial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;700;800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/quantum.css">
</head>
<body>

    <div class="liquid-desktop">
        <div class="liquid-blob blob-1" style="top: -20%; left: -10%;"></div>
        <div class="liquid-blob blob-3" style="bottom: -20%; right: -10%;"></div>
    </div>
    <div class="noise-overlay"></div>

    <div class="desktop-environment" style="display: flex; align-items: center; justify-content: center; padding: 0;">
        
        <div class="spatial-window active" style="position: relative; width: 500px; transform: translateZ(0) scale(1); opacity: 1;">
            <div class="window-bar">
                <div class="window-controls">
                    <span class="win-btn close-btn" style="background:rgba(255,255,255,0.2)"></span>
                </div>
                <span class="window-title mono">MODO DE RECONFIGURAÇÃO :: UID #<?= str_pad($user["id"], 3, '0', STR_PAD_LEFT) ?></span>
            </div>
            <div class="window-content">
                
                <form action="update.php" method="post" enctype="multipart/form-data" class="quantum-form">
                    <input type="hidden" name="id" value="<?= $user["id"] ?>">

                    <div class="q-input-group">
                        <label>IDENTIFICAÇÃO DO OPERADOR</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user["name"]) ?>" required>
                        <span class="input-focus-line"></span>
                    </div>
                    
                    <div class="q-input-group">
                        <label>CANAL DE COMUNICAÇÃO</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
                        <span class="input-focus-line"></span>
                    </div>

                    <div style="display: flex; gap: 15px;">
                        <div class="q-input-group" style="flex: 1;">
                            <label>DOC DE IDENTIFICAÇÃO</label>
                            <input type="text" name="cpf" id="editCpf" value="<?= htmlspecialchars($user["cpf"] ?? '') ?>" required>
                            <span class="input-focus-line"></span>
                        </div>
                        <div class="q-input-group" style="flex: 1;">
                            <label>SINAL MÓVEL (CEL)</label>
                            <input type="text" name="phone" id="editPhone" value="<?= htmlspecialchars($user["phone"] ?? '') ?>" required>
                            <span class="input-focus-line"></span>
                        </div>
                    </div>
                    
                    <div class="q-input-group">
                        <label>VETOR DE ACESSO</label>
                        <select name="document" class="q-select" required>
                            <?php
                            $cursos = ['Engenharia de Computação', 'Ciência da Computação', 'Sistemas de Informação', 'Segurança da Informação'];
                            foreach($cursos as $c) {
                                $selected = ($user['document'] == $c) ? 'selected' : '';
                                echo "<option value=\"$c\" $selected>$c</option>";
                            }
                            ?>
                        </select>
                        <span class="input-focus-line"></span>
                    </div>

                    <div class="q-input-group">
                        <label>ATUALIZAR SCAN BIOMÉTRICO (FOTO OPCIONAL)</label>
                        <input type="file" name="avatar" class="q-select" accept="image/png, image/jpeg, image/webp" style="padding: 12px 15px;">
                        <span class="input-focus-line"></span>
                    </div>
                    
                    <div style="display: flex; gap: 15px; margin-top: 10px;">
                        <a href="index.php" class="quantum-btn secondary" style="flex: 1; text-align: center; text-decoration: none; clip-path: none; border-radius: 8px;">CANCELAR</a>
                        <button type="submit" class="quantum-btn primary" style="flex: 1; clip-path: none; border-radius: 8px;">SALVAR ALTERAÇÕES</button>
                    </div>
                </form>
            </div>
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