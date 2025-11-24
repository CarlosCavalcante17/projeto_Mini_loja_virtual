<?php
session_start();
include '../config/conexao.php'; 

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($nome && $email && $senha) {
    
    $stmt = $conexao->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $stmt->store_result(); 
    
    if ($stmt->num_rows > 0) {
        $stmt->close();
        header('Location: ../registro.php?erro=email_existe');
        exit;
    }
    $stmt->close();

    
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    
    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha_hash);
    
    if ($stmt->execute()) {
        
        $_SESSION['id_usuario'] = $conexao->insert_id; 
        $_SESSION['nome_usuario'] = $nome;
        
        $stmt->close();
        header('Location: ../index.php');
        exit;
    }
    $stmt->close();
}

header('Location: ../registro.php?erro=geral');
exit;
?>