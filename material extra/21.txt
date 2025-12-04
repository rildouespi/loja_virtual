<?php // CAMINHO DO ARQUIVO: admin/marca_delete.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$id = isset($_POST['id']) ? (int) $_POST['id'] : 0;

if ($id <= 0) {
    header('Location: ../public/admin_marcas.php?msg=' . urlencode('ID inválido.'));
    exit;
}

// Verifica se há produtos usando essa marca
$stmtCheck = $pdo->prepare("SELECT COUNT(*) AS total FROM produtos WHERE id_marca = :id");
$stmtCheck->execute([':id' => $id]);
$total = $stmtCheck->fetchColumn();

if ($total > 0) {
    header('Location: ../public/admin_marcas.php?msg=' . urlencode('Não é possível apagar: existem produtos usando essa marca.'));
    exit;
}

// Remove marca
$stmt = $pdo->prepare("DELETE FROM marcas WHERE id_marca = :id");
$stmt->execute([':id' => $id]);

header('Location: ../public/admin_marcas.php?msg=' . urlencode('Marca removida.'));
exit;
