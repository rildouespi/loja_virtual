<?php // CAMINHO DO ARQUIVO: includes/auth_check.php

session_start();

if (!isset($_SESSION['admin_user'])) {
    header('Location: login.php');
    exit;
}
