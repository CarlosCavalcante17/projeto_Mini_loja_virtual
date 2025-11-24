<?php
   $host = "localhost";
   $db = 'mini_loja';   
   $user = "root";
   $pass = " ";
   $conexao_temp->query("CREATE DATABASE IF NOT EXISTS mini_loja");
   $conexao_temp->close();


   $conexao = new mysqli($host, $user, $pass, $db);
   if ($conexao->connect_error) {
      die("Erro na conexão: " . $conexao->connect_error);
   }
   

   $sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios(
   Id INT AUTO_INCREMENT PRIMARY KEY,
   nome VARCHAR(100) NOT NULL,
   email VARCHAR(100) NOT NULL,
   senha VARCHAR(255) NOT NULL,
   data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   )";

   $conexao->query($sql_usuarios);

   $sql_produtos = "CREATE TABLE IF NOT EXISTS produtos(
   Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
   nome VARCHAR(150) NOT NULL,
   descricao TEXT,
   preco DECIMAL (10,2) NOT NULL,
   imagem_url VARCHAR(255),
   data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
   )";

   $conexao->query($sql_produtos);

   $sql_pedidos = "CREATE TABLE IF NOT EXISTS pedidos (
   Id INT AUTO_INCREMENT PRIMARY KEY,
   Id_usuario INT NOT NULL,
   data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   valor_total DECIMAL(10, 2) NOT NULL,
   status VARCHAR(50) DEFAULT 'processando',
   FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
   )";
   $conexao->query($sql_pedidos);

   $sql_itens = "CREATE TABLE IF NOT EXISTS itens_pedidos (
   id INT AUTO_INCREMENT PRIMARY KEY,
   Id_pedido INT NOT NULL,
   Id_produto INT NOT NULL,
   quantidade INT NOT NULL,
   preco_unitario DECIMAL(10, 2) NOT NULL,
   FOREIGN KEY(Id_pedido) REFERENCES pedidos(Id) ON DELETE CASCADE,
   FOREIGN KEY(Id_produto) REFERENCES produtos(Id)
   )";
   $conexao->query($sql_itens);
?>
