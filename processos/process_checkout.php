<?php
session_start();
include '../config/conexao.php';

if (!isset($_SESSION['id_usuario']) || empty($_SESSION['carrinho'])) {
    header('Location: ../index.php');
    exit;
}


$conexao->begin_transaction();

try {
    
    $ids = implode(',', array_keys($_SESSION['carrinho']));
    $result = $conexao->query("SELECT id, preco FROM produtos WHERE id IN ($ids)");
    
    $total = 0;
    $itens_para_inserir = [];

    while ($prod = $result->fetch_assoc()) {
        $qtd = $_SESSION['carrinho'][$prod['id']];
        $total += $prod['preco'] * $qtd;
        $itens_para_inserir[] = [
            'id_produto' => $prod['id'],
            'qtd' => $qtd,
            'preco' => $prod['preco']
        ];
    }

    
    $stmt = $conexao->prepare("INSERT INTO pedidos (id_usuario, valor_total, status) VALUES (?, ?, 'processando')");
    $stmt->bind_param("id", $_SESSION['id_usuario'], $total);
    $stmt->execute();
    $id_pedido = $conexao->insert_id;
    $stmt->close();

    
    $stmtItem = $conexao->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
    
    foreach ($itens_para_inserir as $item) {
        
        $stmtItem->bind_param("iiid", $id_pedido, $item['id_produto'], $item['qtd'], $item['preco']);
        $stmtItem->execute();
    }
    $stmtItem->close();

    $conexao->commit();
    
    unset($_SESSION['carrinho']);
    header('Location: ../meus_pedidos.php');

} catch (Exception $e) {
    $conexao->rollback(); 
    die("Erro ao processar: " . $e->getMessage());
}
?>