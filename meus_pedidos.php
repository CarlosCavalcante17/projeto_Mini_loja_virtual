<?php
include 'config/auth_check.php';
include 'config/conexao.php';
include 'template/header.php';

$id_usuario = $_SESSION['id_usuario'];


$stmt = $conexao->prepare("SELECT * FROM pedidos WHERE id_usuario = ? ORDER BY data_pedido DESC");
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = $result->fetch_all(MYSQLI_ASSOC);
?>

<h2>Meus pedidos</h2>

<?php if (count($pedidos) === 0): ?>
    <div class = "alert alert-info">Você ainda não fez nenhum pedido.</div>
    <a href="index.php" class = "btn btn-primary">Ver compras</a>
<?php else: ?>
    <div class="row">
        <?php foreach($pedidos as $pedido): ?>
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span><strong>Pedido #<?php echo $pedido['id']; ?></strong></span>
                        <span class="badge bg-secondary"><?php echo date('d/m/Y H:i', strtotime($pedido['data_pedido'])); ?></span>
                    </div>
                    <div class="card-body">
                        <h5 class="text-success">R$ <?php echo number_format($pedido['valor_total'], 2, ',', '.'); ?></h5>
                        <span class="badge bg-primary"><?php echo ucfirst($pedido['status']); ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php 
$stmt->close();
include 'template/footer.php'; 
?>