<?php // CAMINHO DO ARQUIVO: public/produto.php

require_once __DIR__ . '/../config/db.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die('ID de produto inválido.');
}

// Buscar produto
$sql = "
    SELECT 
        p.*, c.nome AS categoria_nome, m.nome AS marca_nome
    FROM produtos p
    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria
    LEFT JOIN marcas m ON p.id_marca = m.id_marca
    WHERE p.id_produto = :id
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch();

if (!$produto) {
    die('Produto não encontrado.');
}

// Imagens adicionais
$stmtImg = $pdo->prepare("SELECT * FROM imagens_produto 
WHERE id_produto = :id ORDER BY ordem ASC");
$stmtImg->execute([':id' => $id]);
$imagens = $stmtImg->fetchAll();

 __DIR__ . '/../includes/header.php';
?>

<div class="detalhe-produto">
    <div>
        <?php
        $imgPrincipal = $produto['imagem_url'] ?: ($imagens[0]['url'] ?? 'img/layout/sem_imagem.png');
        ?>
        <img id="img-principal" src="<?= htmlspecialchars($imgPrincipal) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
        <?php if (count($imagens) > 1): ?>
            <div style="margin-top:10px;">
                <?php foreach ($imagens as $img): ?>
                    <img src="<?= htmlspecialchars($img['url']) ?>" 
                         style="width:80px;height:80px;object-fit:cover;margin-right:5px;cursor:pointer;"
                         onclick="document.getElementById('img-principal').src='<?= htmlspecialchars($img['url']) ?>'">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="detalhe-info">
        <h2><?= htmlspecialchars($produto['nome']) ?></h2>
        <p><strong>Preço:</strong> R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
        <?php if ($produto['categoria_nome']): ?>
            <p><strong>Categoria:</strong> <?= htmlspecialchars($produto['categoria_nome']) ?></p>
        <?php endif; ?>
        <?php if ($produto['marca_nome']): ?>
            <p><strong>Marca:</strong> <?= htmlspecialchars($produto['marca_nome']) ?></p>
        <?php endif; ?>
        <p style="margin-top:15px;">
            <?= $produto['descricao'] ? nl2br(htmlspecialchars($produto['descricao'])) : 'Sem descrição.' ?>
        </p>
        <p style="margin-top:15px;"><em>Estoque: <?= (int) $produto['estoque'] ?></em></p>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
