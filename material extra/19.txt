<?php // CAMINHO DO ARQUIVO: admin/categoria_delete.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    header('Location: ../public/admin_categorias.php?msg=' . urlencode('ID inválido.'));
    exit;
}

// Verifica se há produtos usando essa categoria
$stmtCheck = $pdo->prepare("SELECT COUNT(*) AS total FROM produtos WHERE id_categoria = :id");
$stmtCheck->execute([':id' => $id]);
$total = $stmtCheck->fetchColumn();

if ($total > 0) {
    header('Location: ../public/admin_categorias.php?msg=' . urlencode('Não é possível apagar: existem produtos usando essa categoria.'));
    exit;
}

// Remove categoria
$stmt = $pdo->prepare("DELETE FROM categorias WHERE id_categoria = :id");
$stmt->execute([':id' => $id]);

header('Location: ../public/admin_categorias.php?msg=' . urlencode('Categoria removida.'));
exit;
