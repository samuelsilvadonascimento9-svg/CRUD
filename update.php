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

/**
 * Captura o ID do usuário que será editado.
 */
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

/**
 * Captura os dados enviados pelo formulário via método POST e limpa espaços.
 */
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$cpf = trim($_POST["cpf"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$document = trim($_POST["document"] ?? ""); // Curso

if (!$id || $name === "" || $email === "" || $cpf === "" || $phone === "" || $document === "") {
    $_SESSION['toast_error'] = "Preencha todos os campos obrigatórios para editar.";
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
// BLINDAGEM MATEMÁTICA DE CPF (EDIÇÃO)
// ==========================================
if (!Validator::isCpfValid($cpf)) {
    $_SESSION['toast_error'] = "Acesso negado: O CPF informado na edição é inválido matematicamente.";
    header("Location: index.php");
    exit;
}

$params = [
    ":name" => $name,
    ":email" => $email,
    ":cpf" => $cpf,
    ":phone" => $phone,
    ":document" => $document,
    ":id" => $id
];

/**
 * PROCESSAMENTO DO UPLOAD DO AVATAR NA EDIÇÃO
 */
$updateAvatarSQL = ""; 

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    
    if (in_array($fileExtension, $allowedExtensions)) {
        $avatarName = md5(time() . $fileName) . '.' . $fileExtension;
        $destinationPath = __DIR__ . '/uploads/avatars/' . $avatarName;
        
        if (move_uploaded_file($fileTmpPath, $destinationPath)) {
            $updateAvatarSQL = ", avatar = :avatar"; 
            $params[':avatar'] = $avatarName;
        } else {
            $_SESSION['toast_error'] = "Falha ao salvar a nova imagem no servidor.";
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['toast_error'] = "Apenas imagens (JPG, PNG, WEBP) são permitidas.";
        header("Location: index.php");
        exit;
    }
}

/**
 * Obtém a conexão e faz o UPDATE correto (e não INSERT!)
 */
$pdo = Connect::getInstance();

try {
    $stmt = $pdo->prepare("
        UPDATE users 
        SET name = :name, email = :email, cpf = :cpf, phone = :phone, document = :document {$updateAvatarSQL} 
        WHERE id = :id
    ");

    $stmt->execute($params);
    $_SESSION['toast_success'] = "Registro atualizado com sucesso!";
} catch (PDOException $e) {
    $_SESSION['toast_error'] = "Erro interno ao atualizar registro.";
}

header("Location: index.php");
exit;