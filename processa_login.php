<?php
// processa_login.php (versão sem Google Client)

// Inicia a sessão
session_start();

// Verifica se o e-mail e a senha foram enviados via POST
if (!isset($_POST['email']) || !isset($_POST['senha'])) {
    die('E-mail e senha são obrigatórios.');
}

// Dados recebidos do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Simulação de autenticação (substitua por uma lógica real de banco de dados)
$usuario_valido = false;
if ($email === 'usuario@exemplo.com' && $senha === '123456') {
    $usuario_valido = true;
    $nome = 'Usuário de Teste'; // Nome fictício para o exemplo
}

// Se o usuário for válido, inicia a sessão
if ($usuario_valido) {
    // Armazena as informações na sessão
    $_SESSION['email'] = $email;
    $_SESSION['nome'] = $nome;

    // Redireciona para a página inicial (ou outra página desejada)
    header("Location: index.html");
    exit();
} else {
    // Se o login falhar, exibe uma mensagem de erro
    die('E-mail ou senha incorretos.');
}
?>