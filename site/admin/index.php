<?php


require_once 'db.class.php';
require_once 'header.php';

redirectIfNotLoggedIn();


class Model {
    protected $db;
    protected $table;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}


$database = new Database();
$conn = $database->getConnection();

$totalPosts = $conn->query("SELECT COUNT(*) FROM artigos")->fetchColumn();
$totalCategorias = $conn->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
$totalUsuarios = $conn->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
?>

<h2>Dashboard - Sistema de Artigos Antigos</h2>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-newspaper"></i> Artigos</h5>
                <h2><?php echo $totalPosts; ?></h2>
                <a href="../post/PostList.php" class="text-white">Ver todos</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-tags"></i> Categorias</h5>
                <h2><?php echo $totalCategorias; ?></h2>
                <a href="../categoria/CategoriaList.php" class="text-white">Ver todas</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-users"></i> Usuários</h5>
                <h2><?php echo $totalUsuarios; ?></h2>
                <a href="../usuario/UsuarioList.php" class="text-white">Ver todos</a>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>