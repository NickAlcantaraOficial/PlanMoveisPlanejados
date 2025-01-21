<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Senha padrão do XAMPP
$dbname = "Plan_Moveis_Planejados";

// Criação de conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Recebe os dados do formulário e faz a sanitização
$nome = trim($_POST['nome']);
$data_nascimento = $_POST['data_nascimento'];
$email = trim($_POST['email']);
$telefone = trim($_POST['telefone']);
$senha = trim($_POST['senha']); // A senha não vai ser hashed ainda, vamos validá-la antes

// Validações simples
if (empty($nome) || empty($email) || empty($telefone) || empty($senha)) {
    echo "Todos os campos são obrigatórios!";
    exit;
}

// Validação de E-mail
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "O e-mail fornecido é inválido!";
    exit;
}

// Validação de Senha
if (strlen($senha) < 8 || !preg_match('/[A-Z]/', $senha) || !preg_match('/[0-9]/', $senha)) {
    echo "A senha deve ter pelo menos 8 caracteres, uma letra maiúscula e um número!";
    exit;
}

// Fazendo o hash da senha para segurança
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Prepara a query usando prepared statements para evitar SQL Injection
$stmt = $conn->prepare("INSERT INTO cadastros (nome, data_nascimento, email, telefone, senha) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $data_nascimento, $email, $telefone, $senha_hash);

// Executa a inserção
if ($stmt->execute()) {
    // Redireciona para a página de login
    header('Location: login.php');
    exit;
} else {
    echo "Erro: " . $stmt->error;
}

// Fecha a conexão
$stmt->close();
$conn->close();
?>
