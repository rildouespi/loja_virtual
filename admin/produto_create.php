<?php // CAMINHO DO ARQUIVO: admin/produto_create.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : null;
$preco = isset($_POST['preco']) ? (float) $_POST['preco'] : 0;
$estoque = isset($_POST['estoque']) ? (int) $_POST['estoque'] : 0;
$id_categoria = isset($_POST['id_categoria']) && $_POST['id_categoria'] !== '' ? (int) $_POST['id_categoria'] : null;
$id_marca = isset($_POST['id_marca']) && $_POST['id_marca'] !== '' ? (int) $_POST['id_marca'] : null;
$imagem_url = isset($_POST['imagem_url']) ? trim($_POST['imagem_url']) : null;

if ($nome === '' || $preco <= 0) {
    header('Location: ../public/admin.php?msg=' . urlencode('Nome e preço são obrigatórios.'));
    exit;
}

$sql = "
    INSERT INTO produtos
    (nome, descricao, preco, estoque, id_categoria, id_marca, imagem_url, ativo)
    VALUES (:nome, :descricao, :preco, :estoque, :id_categoria, :id_marca, :imagem_url, 1)
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome'        => $nome,
    ':descricao'   => $descricao ?: null,
    ':preco'       => $preco,
    ':estoque'     => $estoque,
    ':id_categoria'=> $id_categoria,
    ':id_marca'    => $id_marca,
    ':imagem_url'  => $imagem_url ?: null
]);

header('Location: ../public/admin.php?msg=' . urlencode('Produto criado com sucesso.'));
exit;
