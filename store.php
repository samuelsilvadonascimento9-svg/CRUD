<?php
/**
 * Inclui o arquivo de conexão com o banco de dados e a classe Validadora.
 */
require __DIR__ . "/connect.php";
require __DIR__ . "/Validator.php"; // <--- Novo: Inclui o motor de validação!

// ==========================================
// PROTEÇÃO DA ROTA (SÓ ENTRA LOGADO)
// ==========================================
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$cpf = trim($_POST["cpf"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$document = trim($_POST["document"] ?? ""); // Curso

if ($name === "" || $email === "" || $cpf === "" || $phone === "" || $document === "") {
    $_SESSION['toast_error'] = "Preencha todos os campos obrigatórios.";
    header("Location: index.php");
    exit;
}

if (strlen($name) < 3) {
    $_SESSION['toast_error'] = "O nome deve ter pelo menos 3 letras.";
    header("Location: index.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['toast_error'] = "O formato de e-mail é inválido.";
    header("Location: index.php");
    exit;
}

// ==========================================
// BLINDAGEM MATEMÁTICA DE CPF
// ==========================================
if (!Validator::isCpfValid($cpf)) {
    $_SESSION['toast_error'] = "Acesso negado: O CPF informado não existe ou é inválido matematicamente.";
    header("Location: index.php");
    exit;
}

/**
 * PROCESSAMENTO DO UPLOAD DO AVATAR
 */
$avatarName = 'default.png'; 

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedExtensions)) {
        $avatarName = md5(time() . $fileName) . '.' . $fileExtension;
        $destinationPath = __DIR__ . '/uploads/avatars/' . $avatarName;
        
        if (!move_uploaded_file($fileTmpPath, $destinationPath)) {
            $_SESSION['toast_error'] = "Falha ao mover a imagem para o servidor.";
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['toast_error'] = "Apenas imagens (JPG, PNG, WEBP) são permitidas.";
        header("Location: index.php");
        exit;
    }
}

$pdo = Connect::getInstance();
$stmt = $pdo->prepare("INSERT INTO users (name, email, cpf, phone, document, avatar) VALUES (:name, :email, :cpf, :phone, :document, :avatar)");

try {
    $stmt->execute([
        ":name" => $name, ":email" => $email, ":cpf" => $cpf, 
        ":phone" => $phone, ":document" => $document, ":avatar" => $avatarName
    ]);
    $_SESSION['toast_success'] = "Operador cadastrado com sucesso!";
} catch (PDOException $e) {
    $_SESSION['toast_error'] = "Erro interno ao cadastrar operador.";
}

header("Location: index.php");
exit;