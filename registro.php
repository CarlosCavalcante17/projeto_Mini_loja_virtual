<?php include 'templates/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4>Crie sua Conta</h4>
            </div>
            <div class="card-body">
                
                <?php if (isset($_GET['erro']) && $_GET['erro'] == 'email_existe'): ?>
                    <div class="alert alert-warning">Este email já está cadastrado. Tente fazer login.</div>
                <?php endif; ?>

                <form action="process/registro_process.php" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" name="senha" id="senha" class="form-control" required minlength="6">
                        <div class="form-text">A senha deve ter no mínimo 6 caracteres.</div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                Já tem uma conta? <a href="login.php">Faça Login</a>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>