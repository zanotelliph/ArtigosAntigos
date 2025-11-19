<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['usuario_id']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: /ArtigosAntigos/site/usuario/UsuarioForm.php"); // absoluto do localhost
        exit();
    }
}

function logout() {
    session_destroy();
    header("Location: /ArtigosAntigos/site/usuario/UsuarioForm.php"); // absoluto do localhost
    exit();
}


$title = $title ?? 'Sistema de Objetos Antigos';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .navbar-brand { font-weight: bold; }
        .table-actions { white-space: nowrap; }
        .main-container { margin-top: 20px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/ArtigosAntigos/index.php">
            <i class="fas fa-scroll"></i> Objetos Antigos
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="/ArtigosAntigos/index.php"><i class="fas fa-home"></i> Início</a>
            <a class="nav-link" href="/ArtigosAntigos/site/admin/post/PostList.php"><i class="fas fa-newspaper"></i> Objetos</a>
            <a class="nav-link" href="/ArtigosAntigos/site/admin/categoria/CategoriaList.php"><i class="fas fa-tags"></i> Categorias</a>
            <a class="nav-link" href="/ArtigosAntigos/site/admin/usuario/UsuarioList.php"><i class="fas fa-users"></i> Usuários</a>
            <a class="nav-link" href="?logout=true"><i class="fas fa-sign-out-alt"></i> Sair</a>
        </div>
    </div>
</nav>

<div class="container main-container">
<?php
if (isset($_GET['logout'])) {
    logout();
}
?>
