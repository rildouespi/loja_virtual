<?php // CAMINHO DO ARQUIVO: admin/marca_create.php

require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config/db.php';

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$site = isset($_POST['site']) ? trim($_POST['site']) : null;
$logo_url = isset($_POST['logo_url']) ? trim($_POST['logo_url']) : null;
$ativo = isset($_POST['ativo']) ? 1 : 0;

if ($nome === '') {
    header('Location: ../public/admin_marcas.php?msg=' . urlencode('Nome é obrigatório.'));
    exit;
}

$sql = "
    INSERT INTO marcas (nome, site, logo_url, ativo)
    VALUES (:nome, :site, :logo_url, :ativo)
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome'     => $nome,
    ':site'     => $site ?: null,
    ':logo_url' => $logo_url ?: null,
    ':ativo'    => $ativo
]);

header('Location: ../public/admin_marcas.php?msg=' . urlencode('Marca criada com sucesso.'));
exit;
