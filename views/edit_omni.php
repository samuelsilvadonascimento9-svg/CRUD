<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Omni // Editar Operador</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=JetBrains+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/omni.css">
</head>
<body>
    <div class="edit-container">
        <div class="bionic-card edit-card">
            <header class="edit-header">
                <div class="badge-status" style="margin-bottom: 15px;">
                    <span class="dot-pulse"></span> MODO DE EDIÇÃO ATIVO
                </div>
                <h2 style="font-size: 1.5rem; letter-spacing: -0.5px;">Atualizar Credenciais</h2>
                <p style="color: var(--text-secondary); font-size: 0.85rem; margin-top: 5px;">
                    Modificando registro: <span style="font-family: 'JetBrains Mono'; color: var(--accent);">#<?= str_pad($user['id'], 3, '0', STR_PAD_LEFT) ?></span>
                </p>
            </header>

            <form action="update.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                
                <div class="form-grid" style="grid-template-columns: 1fr;">
                    <div class="input-block">
                        <label>Nome Completo do Operador</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 20px;">
                    <div class="input-block">
                        <label>Email Corporativo</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>
                    <div class="input-block">
                        <label>Celular / Signal</label>
                        <input type="text" name="phone" id="phoneMask" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-grid" style="margin-top: 20px;">
                    <div class="input-block">
                        <label>Vetor / Curso</label>
                        <select name="document" class="neo-select" required>
                            <?php 
                            $cursos = ["Engenharia de Computação", "Ciência da Computação", "Sistemas de Informação", "Segurança da Informação"];
                            foreach($cursos as $c): ?>
                                <option value="<?= $c ?>" <?= $user['document'] == $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-block">
                        <label>Foto de Identificação</label>
                        <input type="file" name="avatar" class="neo-select" style="padding: 9px;">
                    </div>
                </div>

                <div class="edit-footer">
                    <button type="submit" class="btn-primary" style="flex: 2;">Sincronizar Alterações</button>
                    <a href="index.php" class="btn-secondary" style="flex: 1;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/js/omni.js"></script>
</body>
</html>