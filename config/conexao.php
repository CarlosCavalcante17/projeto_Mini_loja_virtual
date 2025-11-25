<?php
   $host = "localhost";
   $db = 'mini_loja_2';   
   $user = "root";
   $pass = "";
   


   $conexao = new mysqli($host, $user, $pass, $db);
   if ($conexao->connect_error) {
      die("Erro na conexão: " . $conexao->connect_error);
   }
