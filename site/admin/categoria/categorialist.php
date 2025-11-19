<?php
require_once __DIR__ . '/CategoriaControle.php';
require_once __DIR__ . '/../admin/header.php';

redirectIfNotLoggedIn();

$categoriaModel = new Categoria();

if (isset($_GET['excluir'])) {
    $categoriaModel->delete($_GET['excluir']);
    $mensagem = "Categoria excluída com sucesso!";
}

$categorias = $categoriaModel->getAll();
?>

<h2>Gerenciar Categorias</h2>

<?php if (!empty($_GET['mensagem'])): ?>
    <div class="alert alert-success"><?php echo $_GET['mensagem']; ?></div>
<?php endif; ?>

<a href="CategoriaForm.php" class="btn btn-primary mb-3">Nova Categoria</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cat = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $cat['id']; ?></td>
            <td><?php echo htmlspecialchars($cat['nome']); ?></td>
            <td><?php echo htmlspecialchars($cat['descricao']); ?></td>
            <td>
                <a href="CategoriaForm.php?id=<?php echo $cat['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="?excluir=<?php echo $cat['id']; ?>" onclick="return confirm('Tem certeza?')" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
