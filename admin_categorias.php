<?php // CAMINHO DO ARQUIVO: public/admin_categorias.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

// Lista categorias
$stmt = $pdo->query("SELECT * FROM categorias ORDER BY id_categoria DESC");
$categorias = $stmt->fetchAll();

$mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';

include __DIR__ . '/../includes/header.php';
?>

<p>
    <a href="admin.php">Voltar para Admin Produtos</a> |
    <a href="../admin/logout.php">Sair</a>
</p>

<h2>Admin - Categorias</h2>

<?php if ($mensagem): ?>
    <p class="mensagem" style="color:green;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<table class="table-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Slug</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$categorias): ?>
        <tr><td colspan="5">Nenhuma categoria cadastrado.</td></tr>
    <?php else: ?>
        <?php foreach ($categorias as $c): ?>
            <tr>
                <td><?= $c['id_categoria'] ?></td>
                <td><?= htmlspecialchars($c['nome']) ?></td>
                <td><?= htmlspecialchars($c['slug']) ?></td>
                <td><?= $c['ativo'] ? 'Sim' : 'Não' ?></td>
                <td>
                    <form method="post" action="../admin/categoria_delete.php" style="display:inline;"
                          onsubmit="return confirm('Remover categoria <?= $c['id_categoria'] ?>?');">
                        <input type="hidden" name="id" value="<?= $c['id_categoria'] ?>">
                        <button type="submit" class="btn">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<div class="form-admin">
    <h3>Nova categoria</h3>
    <form method="post" action="../admin/categoria_create.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="slug" placeholder="Slug (opcional)">
        <textarea name="descricao" placeholder="Descrição (opcional)"></textarea>
        <label>
            <input type="checkbox" name="ativo" value="1" checked>
            Ativa
        </label>
        <button type="submit" class="btn">Salvar</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
