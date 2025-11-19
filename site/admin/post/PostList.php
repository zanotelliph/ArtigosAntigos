<?php
require_once __DIR__ . '/UsuarioControle.php';
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../categoria/CategoriaControle.php';

redirectIfNotLoggedIn();

$postModel = new Post();
$categoriaModel = new Categoria();

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

<a href="?acao=criar" class="btn btn-primary mb-3">Novo Objeto</a>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="termo" class="form-control" placeholder="Buscar por nome ou ano..." value="<?php echo $_GET['termo'] ?? ''; ?>">
        <button type="submit" name="buscar" class="btn btn-secondary">Buscar</button>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ano</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($post = $posts->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $post['id']; ?></td>
            <td><?php echo htmlspecialchars($post['nome']); ?></td>
            <td><?php echo $post['ano_fabricacao']; ?></td>
            <td><?php echo $post['categoria_nome'] ?? 'Sem categoria'; ?></td>
            <td>
                <a href="PostForm.php?id=<?php echo $post['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="?excluir=<?php echo $post['id']; ?>" onclick="return confirm('Tem certeza?')" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once '../site/admin/footer.php'; ?>
