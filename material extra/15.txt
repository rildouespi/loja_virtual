<?php // CAMINHO DO ARQUIVO: admin/logout.php

session_start();
session_destroy();
header('Location: ../public/login.php');
exit;
