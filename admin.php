<?php // CAMINHO DO ARQUIVO: public/admin.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

// Buscar produtos
$stmtProd = $pdo->query("
    SELECT p.id_produto, p.nome, p.preco, p.estoque
    FROM produtos p
    ORDER BY p.id_produto DESC
");
$produtos = $stmtProd->fetchAll();

$mensagem = isset($_GET['msg']) ? $_GET['msg'] : '';

include __DIR__ . '/../includes/header.php';
?>

<p>
    <a href="index.php">Voltar para loja</a> |
    <a href="../admin/logout.php">Sair</a>
</p>

<h2>Admin - Produtos</h2>

<p>
    <a href="admin_categorias.php">Gerenciar Categorias</a> |
    <a href="admin_marcas.php">Gerenciar Marcas</a>
</p>

<?php if ($mensagem): ?>
    <p class="mensagem" style="color:green;"><?= htmlspecialchars($mensagem) ?></p>
<?php endif; ?>

<table class="table-admin">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!$produtos): ?>
        <tr><td colspan="5">Nenhum produto cadastrado.</td></tr>
    <?php else: ?>
        <?php foreach ($produtos as $p): ?>
            <tr>
                <td><?= $p['id_produto'] ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
                <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
               td><?= (int) $p['estoque'] ?></td>
                <td>
                    <form method="post" action="../admin/produto_delete.php" style="display:inline;" 
                          onsubmit="return confirm('Remover produto <?= $p['id_produto'] ?>?');">
                        <input type="hidden" name="id" value="<?= $p['id_produto'] ?>">
                        <button type="submit" class="btn">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<div class="form-admin">
    <h3>Novo produto</h3>
    <form method="post" action="../admin/produto_create.php">
        <input type="text" name="nome" placeholder="Nome" required>
        <textarea name="descricao" placeholder="Descrição"></textarea>
        <input type="number" step="0.01" name="preco" placeholder="Preço" required>
        <input type="number" name="estoque" placeholder="Estoque" value="0">
        <input type="number" name="id_categoria" placeholder="ID Categoria (ex: 1)">
        <input type="number" name="id_marca" placeholder="ID Marca (ex: 1)">
        <input type="text" name="imagem_url" placeholder="URL da imagem (opcional)">
        <button type="submit" class="btn">Salvar</button>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
