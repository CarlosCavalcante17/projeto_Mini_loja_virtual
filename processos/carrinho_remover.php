<?php 
session_start();

if (isset($_GET['id'])) {
    $Id_produto = $_GET['id'];

    if (isset($_SESSION['carrinho'][$Id_produto])) {
        unset($_SESSION['carrinho'][$Id_produto]);
    }
}

header('location: ../carrinho.php');
exit;
?>