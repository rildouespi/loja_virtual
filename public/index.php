<?php // CAMINHO DO ARQUIVO: public/index.php

require_once __DIR__ . '/../config/db.php';

$categoria = isset($_GET['categoria']) ? (int) $_GET['categoria'] : null;
$busca = isset($_GET['busca']) ? trim($_GET['busca']) : '';

// Buscar categorias
$stmtCat = $pdo->query("SELECT id_categoria, nome FROM categorias WHERE ativo = 1 ORDER BY nome");
$categorias = $stmtCat->fetchAll();

// Buscar produtos com filtros
$sql = "
    SELECT 
        p.*, c.nome AS categoria_nome, m.nome AS marca_nome
    FROM produtos p
    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
    LEFT JOIN marcas m ON p.id_marca = m.id_marca
    WHERE p.ativo = 1
";
$params = [];

if ($categoria) {
    $sql .= " AND p.id_categoria = :categoria";
    $params[':categoria'] = $categoria;
}

if ($busca !== '') {
    $sql .= " AND p.nome LIKE :busca";
    $params[':busca'] = '%' . $busca . '%';
}

$sql .= " ORDER BY p.data_cadastro DESC";

$stmtProd = $pdo->prepare($sql);
$stmtProd->execute($params);
$produtos = $stmtProd->fetchAll();

include __DIR__ . '/../includes/header.php';
?>
<div class="filtros">
    <form method="get" style="display:flex; gap:10px; align-items:center;">
        <select name="categoria">
            <option value="">Todas as categorias</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id_categoria']) ?>"
                    <?= $categoria == $cat['id_categoria'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="busca" placeholder="Buscar produto..." value="<?= htmlspecialchars($busca) ?>">
        <button type="submit" class="btn">Buscar</button>
    </form>
</div>

<div class="produtos-grid">
    <?php if (!$produtos): ?>
        <p>Nenhum produto encontrado.</p>
    <?php else: ?>
        <?php foreach ($produtos as $p): ?>
            <div class="card-produto">
                <?php
                    // Se quiser usar a pasta de produtos:
                    // Se o campo imagem_url já vier como "img/produtos/arquivo.jpg" do banco, mantenha:
                    $imgSrc = $p['imagem_url']
                        ? htmlspecialchars($p['imagem_url'])
                        : 'img/layout/sem_imagem.png';
                ?>
                <img src="<?= $imgSrc ?>" 
                     alt="<?= htmlspecialchars($p['nome']) ?>">
                <h3>
                    <a href="produto.php?id=<?= $p['id_produto'] ?>">
                        <?= htmlspecialchars($p['nome']) ?>
                    </a>
                </h3>
                <?php if ($p['categoria_nome']): ?>
                    <p>Categoria: <?= htmlspecialchars($p['categoria_nome']) ?></p>
                <?php endif; ?>
                <?php if ($p['marca_nome']): ?>
                    <p>Marca: <?= htmlspecialchars($p['marca_nome']) ?></p>
                <?php endif; ?>
                <p class="preco">
                    R$ <?= number_format($p['preco'], 2, ',', '.') ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
