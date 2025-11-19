<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/site/database/db.class.php';
require_once __DIR__ . '/site/admin/header.php';


redirectIfNotLoggedIn();


$database = new Database();
$conn = $database->getConnection();


$totalPosts = $conn->query("SELECT COUNT(*) FROM objetos")->fetchColumn();
$totalCategorias = $conn->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
$totalUsuarios = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalDuvidas = $conn->query("SELECT COUNT(*) FROM duvidas")->fetchColumn(); 
?>

<h2 class="mt-4">Dashboard - Sistema de Objetos Antigos</h2>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-newspaper"></i> Objetos</h5>
                <h2><?php echo $totalPosts; ?></h2>
                <a href="site/post/PostList.php" class="text-white">Ver todos</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-tags"></i> Categorias</h5>
                <h2><?php echo $totalCategorias; ?></h2>
                <a href="site/categoria/CategoriaList.php" class="text-white">Ver todas</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Usuários</h5>
                <h2><?php echo $totalUsuarios; ?></h2>
                <a href="site/usuario/UsuarioList.php" class="text-white">Ver todos</a>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-question-circle"></i> Dúvidas</h5>
                <h2><?php echo $totalDuvidas; ?></h2>
                <a href="site/duvidas/DuvidaList.php" class="text-white">Ver todas</a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/site/admin/footer.php'; ?>
