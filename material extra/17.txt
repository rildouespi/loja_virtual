<?php // CAMINHO DO ARQUIVO: admin/produto_delete.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    header('Location: ../public/admin.php?msg=' . urlencode('ID inválido.'));
    exit;
}

// Remove produto
$stmt = $pdo->prepare("DELETE FROM produtos WHERE id_produto = :id");
$stmt->execute([':id' => $id]);

header('Location: ../public/admin.php?msg=' . urlencode('Produto removido.'));
exit;
