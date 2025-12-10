<?php // CAMINHO DO ARQUIVO: admin/login_process.php

session_start();
require_once __DIR__ . '/../config/db.php';

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if ($email === '' || $senha === '') {
    header('Location: ../public/login.php?erro=' . urlencode('Preencha todos os campos.'));
    exit;
}

// Busca usuário admin
$stmt = $pdo->prepare("SELECT * FROM usuarios_admin WHERE email = :email AND ativo = 1");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: ../public/login.php?erro=' . urlencode('Usuário não encontrado.'));
    exit;
}

// Comparação simples: senha == senha_hash do banco
if ($senha !== $user['senha_hash']) {
    header('Location: ../public/login.php?erro=' . urlencode('Senha inválida.'));
    exit;
}

$_SESSION['admin_user'] = [
    'id_usuario' => $user['id_usuario'],
    'nome'       => $user['nome'],
    'email'      => $user['email'],
    'perfil'     => $user['perfil']
];

header('Location: ../public/admin.php');
exit;
