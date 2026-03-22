<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><title>OMNI // Edit</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/omni.css">
</head>
<body style="display:flex;justify-content:center;align-items:center;background:var(--bg-app)">
    <div style="width:100%;max-width:500px">
        <div class="bionic-card form-card">
            <h2 style="margin-bottom:20px">Editar Operador</h2>
            <form action="update.php" method="post" class="enterprise-form">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <div class="input-block"><label>Nome</label><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"></div>
                <div class="input-block"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></div>
                <div class="input-block"><label>Curso</label><input type="text" name="document" value="<?= htmlspecialchars($user['document']) ?>"></div>
                <div class="form-footer" style="display:flex;gap:10px">
                    <a href="index.php" class="btn-ghost-sm" style="flex:1;text-align:center;border:1px solid var(--border-strong)">Voltar</a>
                    <button type="submit" class="btn-primary" style="flex:1">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
    <script src="assets/js/omni.js"></script>
</body>
</html>