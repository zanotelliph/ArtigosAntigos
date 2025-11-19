<?php


require_once 'CategoriaControle.php';
require_once '../site/admin/header.php';

redirectIfNotLoggedIn();

$categoriaModel = new Categoria();
$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao']
    ];

    if ($acao === 'criar') {
        if ($categoriaModel->criar($dados)) {
            $mensagem = "Categoria criada com sucesso!";
            $acao = 'listar';
        }
    } elseif ($acao === 'editar') {
        $id = $_GET['id'];
        if ($categoriaModel->atualizar($id, $dados)) {
            $mensagem = "Categoria atualizada com sucesso!";
            $acao = 'listar';
        }
    }
}

if (isset($_GET['excluir'])) {
    if ($categoriaModel->delete($_GET['excluir'])) {
        $mensagem = "Categoria excluída com sucesso!";
    }
}

if (isset($_GET['buscar'])) {
    $categorias = $categoriaModel->buscar($_GET['termo']);
} else {
    $categorias = $categoriaModel->getAll();
}

if ($acao === 'listar'):
?>
    <h2>Gerenciar Categorias</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="../site/admin/index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="?acao=criar" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova Categoria
        </a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="termo" class="form-control" placeholder="Buscar categorias..." 
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
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($categoria = $categorias->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $categoria['id']; ?></td>
                    <td><?php echo htmlspecialchars($categoria['nome']); ?></td>
                    <td><?php echo htmlspecialchars($categoria['descricao']); ?></td>
                    <td><?php echo date('d/m/Y H:i', strtotime($categoria['data_criacao'])); ?></td>
                    <td class="table-actions">
                        <a href="?acao=editar&id=<?php echo $categoria['id']; ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="?excluir=<?php echo $categoria['id']; ?>" class="btn btn-sm btn-danger" 
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
    <h2><?php echo $acao === 'criar' ? 'Criar' : 'Editar'; ?> Categoria</h2>
    
    <?php
    $categoria = [];
    if ($acao === 'editar' && isset($_GET['id'])) {
        $categoria = $categoriaModel->getById($_GET['id']);
    }
    ?>

    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" required
                   value="<?php echo $categoria['nome'] ?? ''; ?>">
        </div>
        
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="4"><?php echo $categoria['descricao'] ?? ''; ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="CategoriaList.php" class="btn btn-secondary">Cancelar</a>
    </form>
<?php endif; ?>

<?php
require_once '../site/admin/footer.php';
?>