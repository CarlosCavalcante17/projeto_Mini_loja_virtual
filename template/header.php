<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$quantidade_carrinho = isset($_SESSION['carrinho']) ? array_sum($_SESSION['carrinho']) : 0;
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini_loja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Mini_loja</a>
            <div class="collapse navbar-collapse">
              <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Produtos</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="carrinho.php">
                        carrinho <span class="badge bg-danger"><?php echo $quantidade_carrinho; ?></span>
                    </a>
                </li>
                <?php if (isset($_SESSION['Id_usuario'])): ?>
                    <li class="nav-item"><a class="nav-link" href="#">Olá, <?php echo $_SESSION['nome_usuario']; ?></a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Sair</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php endinf; ?>
              </ul>
            </div>
        </div>
    </nav>    
    <div class="container">