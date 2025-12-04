<?php // CAMINHO DO ARQUIVO: admin/categoria_create.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$slug = isset($_POST['slug']) ? trim($_POST['slug']) : null;
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : null;
$ativo = isset($_POST['ativo']) ? 1 : 0;

if ($nome === '') {
    header('Location: ../public/admin_categorias.php?msg=' . urlencode('Nome é obrigatório.'));
    exit;
}

$sql = "
    INSERT INTO categorias (nome, slug, descricao, ativo)
    VALUES (:nome, :slug, :descricao, :ativo)
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome'      => $nome,
    ':slug'      => $slug ?: null,
    ':descricao' => $descricao ?: null,
    ':ativo'     => $ativo
]);

header('Location: ../public/admin_categorias.php?msg=' . urlencode('Categoria criada com sucesso.'));
exit;
