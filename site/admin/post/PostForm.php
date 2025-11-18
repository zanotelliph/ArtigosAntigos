<?php

require_once 'PostControle.php';
require_once '../site/admin/header.php';
require_once '../categoria/CategoriaControle.php';

redirectIfNotLoggedIn();

$postModel = new Post(); 
$categoriaModel = new Categoria();

$id = $_GET['id'] ?? null;
$post = [];
$tituloPagina = 'Cadastrar Objeto Antigo';

if ($id) {
    $post = $postModel->getById($id);
    $tituloPagina = 'Editar Objeto Antigo';
}

$categorias = $categoriaModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'], // CORRETO agora
        'ano_fabricacao' => $_POST['ano_fabricacao'],
        'categoria_id' => $_POST['categoria_id'],
        'usuario_id' => $_SESSION['usuario_id'] ?? 1 // garante que sempre tenha valor
    ];

    if ($id) {
        if ($postModel->atualizar($id, $dados)) {
            header("Location: PostList.php?mensagem=Objeto atualizado com sucesso!");
            exit();
        }
    } else {
        if ($postModel->criar($dados)) {
            header("Location: PostList.php?mensagem=Objeto criado com sucesso!");
            exit();
        }
    }
}
?>

<h2><?php echo $tituloPagina; ?></h2>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Objeto</label>
        <input type="text" class="form-control" id="nome" name="nome" required
               value="<?php echo $post['nome'] ?? ''; ?>">
    </div>
    
    <div class="mb-3">
        <label for="ano_fabricacao" class="form-label">Ano de Fabricação</label>
        <input type="number" class="form-control" id="ano_fabricacao" name="ano_fabricacao" required
               value="<?php echo $post['ano_fabricacao'] ?? ''; ?>">
    </div>
    
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select class="form-control" id="categoria_id" name="categoria_id" required>
            <option value="">Selecione uma categoria</option>
            <?php 
            while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
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
