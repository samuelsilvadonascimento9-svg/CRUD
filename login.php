<?php
session_start();
require __DIR__ . "/connect.php";

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header("Location: index.php");
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['usuario'] ?? '');
    $pass = trim($_POST['senha'] ?? '');

    if (empty($user) || empty($pass)) {
        $erro = 'Preencha usuário e senha.';
    } else {
        try {
            $pdo = Connect::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :user LIMIT 1");
            $stmt->execute([':user' => $user]);
            $adminData = $stmt->fetch();

            // password_verify confere se a senha digitada bate com o Hash do banco
            if ($adminData && password_verify($pass, $adminData['password'])) {
                $_SESSION['logado'] = true;
                $_SESSION['admin_user'] = $adminData['username'];
                header("Location: index.php");
                exit;
            } else {
                $erro = 'Acesso Negado: Credenciais inválidas.';
            }
        } catch (PDOException $e) {
            $erro = 'Erro interno ao validar login.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Acadêmico // Auth</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0f172a; color: #f8fafc; font-family: 'Inter', sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-image: radial-gradient(circle at top right, #1e293b, #0f172a); }
        .login-box { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); padding: 40px; border-radius: 16px; width: 100%; max-width: 360px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 20px 40px rgba(0,0,0,0.5); animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .login-box h2 { margin: 0 0 25px 0; text-align: center; font-weight: 800; font-size: 1.8rem; letter-spacing: -1px; }
        .login-box h2 span { color: #38bdf8; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; color: #94a3b8; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; }
        .input-group input { width: 100%; padding: 14px; border-radius: 8px; border: 1px solid #334155; background: #0f172a; color: #fff; outline: none; box-sizing: border-box; font-size: 1rem; transition: 0.3s; }
        .input-group input:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); }
        .btn-submit { width: 100%; padding: 14px; background: #38bdf8; color: #0f172a; border: none; border-radius: 8px; font-weight: 800; cursor: pointer; font-size: 1rem; transition: 0.3s; text-transform: uppercase; }
        .btn-submit:hover { background: #0284c7; color: #fff; transform: translateY(-2px); }
        .error-msg { color: #f87171; text-align: center; margin-bottom: 20px; font-size: 0.9rem; font-weight: 600; background: rgba(248, 113, 113, 0.1); padding: 10px; border-radius: 6px; border: 1px solid rgba(248,113,113,0.2); }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>PORTAL<span>.</span></h2>
        <?php if ($erro): ?>
            <div class="error-msg"><?= $erro ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="input-group">
                <label>Usuário</label>
                <input type="text" name="usuario" autocomplete="off" autofocus required>
            </div>
            <div class="input-group">
                <label>Senha de Acesso</label>
                <input type="password" name="senha" required>
            </div>
            <button type="submit" class="btn-submit">Autenticar</button>
        </form>
    </div>
</body>
</html>