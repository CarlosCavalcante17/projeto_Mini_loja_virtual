<?php 
include 'config/auth_check.php'; 
include 'config/conexao.php';
include 'template/header.php'; 

if (empty($_SESSION['carrinho'])) {
    echo "<div class='alert alert-warning'>Carrinho vazio. <a href='index.php'>Voltar</a></div>";
    include 'templates/footer.php';
    exit;
}

$ids = implode(',', array_keys($_SESSION['carrinho']));

$sql = "SELECT * FROM produtos WHERE id IN ($ids)";
$result = $conexao->query($sql);

$total = 0;
$produtos_lista = []; 

while($prod = $result->fetch_assoc()) {
    $produtos_lista[] = $prod; 
}
?>

<div class="row">
    <div class="col-md-8">
        <h3>Resumo do Pedido</h3>
        <table class="table">
            <thead><tr><th>Produto</th><th>Qtd</th><th>Total</th></tr></thead>
            <tbody>
                <?php foreach ($produtos_lista as $prod): 
                    $qtd = $_SESSION['carrinho'][$prod['id']];
                    $subtotal = $prod['preco'] * $qtd;
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($prod['nome']); ?></td>
                    <td><?php echo $qtd; ?></td>
                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">Finalizar Compra</div>
            <div class="card-body">
                <h4 class="card-title text-center">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h4>
                <hr>
                <p><strong>Cliente:</strong> <?php echo $_SESSION['nome_usuario']; ?></p>
                <div class="d-grid gap-2">
                    <a href="process/checkout_process.php" class="btn btn-success btn-lg">CONFIRMAR PEDIDO</a>
                </div>
                <br>
                <a href="carrinho.php" class="btn btn-outline-secondary w-100">Voltar ao Carrinho</a>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>