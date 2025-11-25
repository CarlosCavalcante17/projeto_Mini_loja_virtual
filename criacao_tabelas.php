<?php

include 'config/conexao.php'; 



$sql_usuarios = "CREATE TABLE IF NOT EXISTS usuarios(
   id INT AUTO_INCREMENT PRIMARY KEY,
   nome VARCHAR(100) NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   senha VARCHAR(255) NOT NULL,
   data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conexao->query($sql_usuarios) === TRUE) {
    echo "Tabela usuarios criada.<br>";
}

$sql_produtos = "CREATE TABLE IF NOT EXISTS produtos(
   id INT AUTO_INCREMENT PRIMARY KEY,
   nome VARCHAR(150) NOT NULL,
   descricao TEXT,
   preco DECIMAL (10,2) NOT NULL,
   imagem_url VARCHAR(255),
   data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if ($conexao->query($sql_produtos) === TRUE) {
    echo "Tabela produtos criada.<br>";
}

$sql_pedidos = "CREATE TABLE IF NOT EXISTS pedidos (
   id INT AUTO_INCREMENT PRIMARY KEY,
   id_usuario INT NOT NULL,
   data_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   valor_total DECIMAL(10, 2) NOT NULL,
   status VARCHAR(50) DEFAULT 'processando',
   FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
)";
if ($conexao->query($sql_pedidos) === TRUE) {
    echo "Tabela pedidos criada.<br>";
}

$sql_itens = "CREATE TABLE IF NOT EXISTS itens_pedido (
   id INT AUTO_INCREMENT PRIMARY KEY,
   id_pedido INT NOT NULL,
   id_produto INT NOT NULL,
   quantidade INT NOT NULL,
   preco_unitario DECIMAL(10, 2) NOT NULL,
   FOREIGN KEY(id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
   FOREIGN KEY(id_produto) REFERENCES produtos(id)
)";
if ($conexao->query($sql_itens) === TRUE) {
    echo "Tabela itens_pedido criada.<br>";
}
?>