<?php
session_start();
require '../config/conexao.php';

// Verifica login e carrinho vazio
if (!isset($_SESSION['id_usuario']) || empty($_SESSION['carrinho'])) {
    header('Location: ../index.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // 1. Calcular total (precisamos buscar os preços atuais)
    $ids = implode(',', array_keys($_SESSION['carrinho']));
    $stmt = $pdo->query("SELECT id, preco FROM produtos WHERE id IN ($ids)");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $total = 0;
    $itens_para_inserir = [];

    foreach ($produtos as $prod) {
        $qtd = $_SESSION['carrinho'][$prod['id']];
        $total += $prod['preco'] * $qtd;
        $itens_para_inserir[] = [
            'id_produto' => $prod['id'],
            'qtd' => $qtd,
            'preco' => $prod['preco']
        ];
    }

    // 2. Criar Pedido
    $stmt = $pdo->prepare("INSERT INTO pedidos (id_usuario, valor_total, status) VALUES (?, ?, 'processando')");
    $stmt->execute([$_SESSION['id_usuario'], $total]);
    $id_pedido = $pdo->lastInsertId();

    // 3. Inserir Itens
    $stmtItem = $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
    foreach ($itens_para_inserir as $item) {
        $stmtItem->execute([$id_pedido, $item['id_produto'], $item['qtd'], $item['preco']]);
    }

    $pdo->commit();
    
    // Limpa o carrinho
    unset($_SESSION['carrinho']);
    
    // Redireciona para sucesso (pode criar uma pagina de obrigado)
    header('Location: ../index.php?sucesso=pedido_realizado');

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erro ao processar pedido: " . $e->getMessage());
}
?>