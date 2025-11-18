<?php
// post/PostForm.php

require_once 'PostControle.php';
require_once '../site/admin/header.php';
require_once '../categoria/CategoriaControle.php';

redirectIfNotLoggedIn();

$postModel = new Post();
$categoriaModel = new Categoria();

$id = $_GET['id'] ?? null;
$post = [];
$tituloPagina = 'Novo Artigo';

if ($id) {
    $post = $postModel->getById($id);
    $tituloPagina = 'Editar Artigo';
}

$categorias = $categoriaModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'],
        'conteudo' => $_POST['conteudo'],
        'data_publicacao' => $_POST['data_publicacao'],
        'autor' => $_POST['autor'],
        'categoria_id' => $_POST['categoria_id'],
        'usuario_id' => $_SESSION['usuario_id']
    ];

    if ($id) {
        if ($postModel->atualizar($id, $dados)) {
            header("Location: PostList.php?mensagem=Artigo atualizado com sucesso!");
            exit();
        }
    } else {
        if ($postModel->criar($dados)) {
            header("Location: PostList.php?mensagem=Artigo criado com sucesso!");
            exit();
        }
    }
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
        <textarea class="form-control" id="conteudo" name="conteudo" rows="6" required><?php echo $post['conteudo'] ?? ''; ?></textarea>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" required
                       value="<?php echo $post['autor'] ?? ''; ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="data_publicacao" class="form-label">Data de Publicação</label>
                <input type="date" class="form-control" id="data_publicacao" name="data_publicacao" required
                       value="<?php echo $post['data_publicacao'] ?? ''; ?>">
            </div>
        </div>
    </div>
    
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select class="form-control" id="categoria_id" name="categoria_id">
            <option value="">Selecione uma categoria</option>
            <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <option value="<?php echo $categoria['id']; ?>" 
                    <?php echo ($post['categoria_id'] ?? '') == $categoria['id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['nome']); ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="PostList.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php
require_once '../site/admin/footer.php';
?>