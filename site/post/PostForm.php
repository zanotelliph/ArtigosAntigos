<?php
require_once __DIR__ . '/PostControle.php';
require_once __DIR__ . '/../admin/header.php';
require_once __DIR__ . '/../categoria/CategoriaControle.php';


redirectIfNotLoggedIn();

$postModel = new Post();
$categoriaModel = new Categoria();

$id = $_GET['id'] ?? null;
$post = [];
$tituloPagina = $id ? 'Editar Objeto' : 'Cadastrar Objeto';

if ($id) {
    $post = $postModel->getById($id);
}

$categorias = $categoriaModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'],
        'conteudo' => $_POST['conteudo'],
        'categoria_id' => $_POST['categoria_id'],
        'autor' => $_POST['autor'],
        'data_publicacao' => $_POST['data_publicacao']
    ];

    if ($id) {
        $postModel->atualizar($id, $dados);
        header("Location: PostList.php?mensagem=Objeto atualizado com sucesso!");
    } else {
        $postModel->criar($dados);
        header("Location: PostList.php?mensagem=Objeto criado com sucesso!");
    }
    exit();
}
?>

<h2><?php echo $tituloPagina; ?></h2>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required
               value="<?php echo $post['titulo'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="conteudo" class="form-label">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo" required><?php echo $post['conteudo'] ?? ''; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select class="form-control" id="categoria_id" name="categoria_id" required>
            <option value="">Selecione uma categoria</option>
            <?php while ($cat = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $cat['id']; ?>"
                    <?php echo ($post['categoria_id'] ?? '') == $cat['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" class="form-control" id="autor" name="autor" required
               value="<?php echo $post['autor'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="data_publicacao" class="form-label">Data de Publicação</label>
        <input type="date" class="form-control" id="data_publicacao" name="data_publicacao"
               value="<?php echo $post['data_publicacao'] ?? date('Y-m-d'); ?>">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="PostList.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
