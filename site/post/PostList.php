<?php
require_once __DIR__ . '/PostControle.php';
require_once __DIR__ . '/../admin/header.php';

redirectIfNotLoggedIn();

$postModel = new Post();

if (isset($_GET['excluir'])) {
    $postModel->delete($_GET['excluir']);
    $mensagem = "Objeto excluído com sucesso!";
}

$posts = isset($_GET['buscar'])
    ? $postModel->buscar($_GET['termo'])
    : $postModel->getAllWithCategory();
?>

<h2>Gerenciar Objetos</h2>

<?php if (!empty($_GET['mensagem'])): ?>
    <div class="alert alert-success"><?php echo $_GET['mensagem']; ?></div>
<?php endif; ?>

<a href="PostForm.php" class="btn btn-primary mb-3">Novo Objeto</a>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="termo" class="form-control" placeholder="Buscar..." value="<?php echo $_GET['termo'] ?? ''; ?>">
        <button type="submit" name="buscar" class="btn btn-secondary">Buscar</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Categoria</th>
            <th>Autor</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($post = $posts->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $post['id']; ?></td>
            <td><?php echo htmlspecialchars($post['titulo']); ?></td>
            <td><?php echo $post['categoria_nome'] ?? 'Sem categoria'; ?></td>
            <td><?php echo $post['autor']; ?></td>
            <td><?php echo $post['data_publicacao']; ?></td>
            <td>
                <a href="PostForm.php?id=<?php echo $post['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="?excluir=<?php echo $post['id']; ?>" onclick="return confirm('Tem certeza?')" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
