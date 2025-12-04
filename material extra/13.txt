<?php // CAMINHO DO ARQUIVO: public/admin_marcas.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

// Lista marcas
$stmt = $pdo->query("SELECT * FROM marcas ORDER BY id_marca DESC");
$marcas = $stmt->fetchAll();

$mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';

include __DIR__ . '/../includes/header.php';
?>

<p>
    <a href="admin.php">Voltar para Admin Produtos</a> |
    <a href="../admin/logout.php">Sair</a>
</p>

<h2>Admin - Marcas</h2>

<?php if ($mensagem): ?>
    <p class="mensagem" style="color:green;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<table class="table-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Site</th>
            <th>Logo URL</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$marcas): ?>
        <tr><td colspan="6">Nenhuma marca cadastrada.</td></tr>
    <?php else: ?>
        <?php foreach ($marcas as $m): ?>
            <tr>
                <td><?= $m['id_marca'] ?></td>
                <td><?= htmlspecialchars($m['nome']) ?></td>
                <td><?= htmlspecialchars($m['site']) ?></td>
                <td><?= htmlspecialchars($m['logo_url']) ?></td>
                <td><?= $m['ativo'] ? 'Sim' : 'Não' ?></td>
                <td>
                    <form method="post" action="../admin/marca_delete.php" style="display:inline;"
                          onsubmit="return confirm('Remover marca <?= $m['id_marca'] ?>?');">
                        <input type="hidden" name="id" value="<?= $m['id_marca'] ?>">
                        <button type="submit" class="btn">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<div class="form-admin">
    <h3>Nova marca</h3>
    <form method="post" action="../admin/marca_create.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="site" placeholder="Site (opcional)">
        <input type="text" name="logo_url" placeholder="Logo URL (opcional)">
        <label>
            <input type="checkbox" name="ativo" value="1" checked>
            Ativa
        </label>
        <button type="submit" class="btn">Salvar</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
