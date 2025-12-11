<?php // CAMINHO DO ARQUIVO: public/login.php

session_start();
if (isset($_SESSION['admin_user'])) {
    header('Location: admin.php');
    exit;
}

$erro = isset($_GET['erro']) ? $_GET['erro'] : '';

include __DIR__ . '/../includes/header.php';
?>

<div class="form-admin">
    <h2>Login</h2>
    <?php if ($erro): ?>
        <p class="mensagem" style="color:red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>
    <form method="post" action="../admin/login_process.php">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
