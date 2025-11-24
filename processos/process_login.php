<?php
session_start();
require '../config/conexao.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email && $senha) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Verifica a senha usando o hash
    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['id_usuario'] = $user['id'];
        $_SESSION['nome_usuario'] = $user['nome'];
        header('Location: ../index.php');
        exit;
    }
}

header('Location: ../login.php?erro=1');
exit;
?>