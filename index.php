<?php 
include 'config/conexao.php';
include 'template/header.php';

$sql = "SELECT * FROM produtos";
$result = $conexao->query($sql);
?>

<div class = "col-12 mb-3">
    <h2>Listagem de produtos</h2>
    <?php if(isset($_GET['sucesso'])): ?>
        <div class ="alert alert-sucess"> Pedido Realizado com sucesso!</div>
    <?php endif;  ?>
</div>

<?php
if ($result && $result->num_rows > 0):
        while($produto = $result->fetch_assoc()): 
    ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="<?php echo !empty($produto['imagem_url']) ? $produto['imagem_url'] : 'https://placehold.co/300'; ?>" class="card-img-top" alt="Imagem do produto" style="height: 200px; object-fit: cover;">
                
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h5>
                    <p class="card-text text-truncate"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                    <h5 class="text-primary mt-auto">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h5>
                    
                    <a href="processos/carrinho_add.php?id=<?php echo $produto['id']; ?>" class="btn btn-primary w-100 mt-2">Adicionar ao Carrinho</a>
                </div>
            </div>
        </div>
    <?php 
        endwhile; 
    else:
    ?>
        <div class="alert alert-warning">Nenhum produto cadastrado ainda.</div>
    <?php endif; ?>
</div>

<?php include 'template/footer.php'; ?>