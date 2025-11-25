<?php include 'template/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <?php if (isset($_GET['erro'])): ?>
                    <div class="alert alert-danger">Email ou senha incorretos.</div>
                <?php endif; ?>
                
                <form action="process/login_process.php" method="POST">
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'template/footer.php'; ?>