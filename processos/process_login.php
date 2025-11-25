<?php
session_start();
include '../config/conexao.php';  

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($email && $senha) {
    $stmt = $conexao->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $stmt->close(); 

    if ($user = $result->fetch_assoc()) {
        if (password_verify($senha, $user['senha'])) {
        
            $_SESSION['id_usuario'] = $user['id'];
            $_SESSION['nome_usuario'] = $user['nome'];
            header('Location: ../index.php');
            exit;
        }
    }
}

header('Location: ../login.php?erro=1');
exit;
?>