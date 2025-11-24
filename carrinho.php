<?php
include 'config/conexao.php';
include 'templates/header.php';

$carrinho = $_SESSION['carrinho'] ?? [];
?>

<h2>Seu Carrinho</h2>

<?php if (empty($carrinho)): ?>
    <div class="alert alert-info">O carrinho está vazio.</div>
<?php else: ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Qtd</th>
                <th>Preço Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Busca detalhes dos produtos que estão na sessão
            $ids = implode(',', array_keys($carrinho));
            $stmt = $pdo->query("SELECT * FROM produtos WHERE id IN ($ids)");
            $produtos = $stmt->fetchAll();
            $total_geral = 0;

            foreach ($produtos as $prod):
                $qtd = $carrinho[$prod['id']];
                $subtotal = $prod['preco'] * $qtd;
                $total_geral += $subtotal;
            ?>
                <tr>
                    <td><?php echo $prod['nome']; ?></td>
                    <td><?php echo $qtd; ?></td>
                    <td>R$ <?php echo number_format($prod['preco'], 2, ',', '.'); ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                <td><strong>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="d-flex justify-content-end">
        <?php if (isset($_SESSION['id_usuario'])): ?>
            <a href="process/checkout_process.php" class="btn btn-success btn-lg">Finalizar Compra</a>
        <?php else: ?>
            <a href="login.php" class="btn btn-warning">Faça Login para Comprar</a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include 'templates/footer.php'; ?>