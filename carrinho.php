<?php

include 'template/header.php';
include 'config/conexao.php';

$carrinho = $_SESSION['carrinho'] ?? [];
$total_carrinho = 0;
$itens_carrinho = [];

if (!empty($carrinho)) {
    
    $ids_carrinho = implode(',', array_keys($carrinho));
    
    $sql = "SELECT id, nome, preco, imagem_url FROM produtos WHERE id IN ($ids_carrinho)";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        while ($produto = $resultado->fetch_assoc()) { 
            $produto_id = $produto['id'];
            $produto['quantidade'] = $carrinho[$produto_id];
            $produto['subtotal'] = $produto['preco'] * $produto['quantidade'];
            
            $total_carrinho += $produto['subtotal'];
            $itens_carrinho[] = $produto;
        }
    }
}
?>

<h2>Seu Carrinho</h2>
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Produto</th>
            <th class="text-center">Qtd</th>
            <th class="text-end">Preço Unit.</th>
            <th class="text-end">Subtotal</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($itens_carrinho)): ?>
            <tr>
                <td colspan="5" class="text-center text-muted">Seu carrinho está vazio.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($itens_carrinho as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td class="text-center"><?php echo $item['quantidade']; ?></td>
                    <td class="text-end">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                    <td class="text-end">R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                    <td class="text-center">
                        <a href="processos/carrinho_remover.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" title="Remover item">
                            Remover
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            
            <tr>
                <td colspan="3" class="text-end fw-bold">Total</td>
                <td class="text-end fw-bold">R$ <?php echo number_format($total_carrinho, 2, ',', '.'); ?></td>
                <td></td>
            </tr>
            
        <?php endif; ?>
    </tbody>
</table>

<?php if (!empty($itens_carrinho)): ?>
    <div class="d-flex justify-content-end mt-4">
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <a href="checkout.php" class="btn btn-success btn-lg">Finalizar Compra</a>
        <?php else: ?>
            <div class="alert alert-warning mb-0">
                <a href="login.php" class="alert-link">Faça login</a> para finalizar a compra.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'template/footer.php'; ?>