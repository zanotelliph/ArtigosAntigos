<?php
// post/PostList.php

require_once 'PostControle.php';
require_once '../site/admin/header.php';
require_once '../categoria/CategoriaControle.php';

redirectIfNotLoggedIn();

$postModel = new Post();
$categoriaModel = new Categoria();
$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'],
        'conteudo' => $_POST['conteudo'],
        'data_publicacao' => $_POST['data_publicacao'],
        'autor' => $_POST['autor'],
        'categoria_id' => $_POST['categoria_id'],
        'usuario_id' => $_SESSION['usuario_id']
    ];

    if ($acao === 'criar') {
        if ($postModel->criar($dados)) {
            $mensagem = "Artigo criado com sucesso!";
            $acao = 'listar';
        }
    } elseif ($acao === 'editar') {
        $id = $_GET['id'];
        if ($postModel->atualizar($id, $dados)) {
            $mensagem = "Artigo atualizado com sucesso!";
            $acao = 'listar';
        }
    }
}

if (isset($_GET['excluir'])) {
    if ($postModel->delete($_GET['excluir'])) {
        $mensagem = "Artigo excluído com sucesso!";
    }
}

if (isset($_GET['buscar'])) {
    $posts = $postModel->buscar($_GET['termo']);
} else {
    $posts = $postModel->getAllWithCategory();
}

$categorias = $categoriaModel->getAll();

if ($acao === 'listar'):
?>
    <h2>Gerenciar Artigos</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="../site/admin/index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="?acao=criar" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Artigo
        </a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="termo" class="form-control" placeholder="Buscar artigos..." 
                   value="<?php echo $_GET['termo'] ?? ''; ?>">
            <button type="submit" name="buscar" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Data</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = $posts->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $post['id']; ?></td>
                    <td><?php echo htmlspecialchars($post['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($post['autor']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($post['data_publicacao'])); ?></td>
                    <td><?php echo $post['categoria_nome'] ?? 'Sem categoria'; ?></td>
                    <td class="table-actions">
                        <a href="?acao=editar&id=<?php echo $post['id']; ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?excluir=<?php echo $post['id']; ?>" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Tem certeza?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($acao === 'criar' || $acao === 'editar'): ?>
    <h2><?php echo $acao === 'criar' ? 'Criar' : 'Editar'; ?> Artigo</h2>
    
    <?php
    $post = [];
    if ($acao === 'editar' && isset($_GET['id'])) {
        $post = $postModel->getById($_GET['id']);
    }
    ?>

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
<?php endif; ?>

<?php
require_once '../site/admin/footer.php';
?>