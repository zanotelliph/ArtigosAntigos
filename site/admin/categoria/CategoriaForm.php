<?php
require_once __DIR__ . '/CategoriaControle.php';
require_once __DIR__ . '/../admin/header.php';

redirectIfNotLoggedIn();

$categoriaModel = new Categoria();
$id = $_GET['id'] ?? null;
$categoria = [];
$tituloPagina = $id ? 'Editar Categoria' : 'Cadastrar Categoria';

if ($id) {
    $categoria = $categoriaModel->getById($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'descricao' => $_POST['descricao']
    ];

    if ($id) {
        $categoriaModel->atualizar($id, $dados);
        header("Location: CategoriaList.php?mensagem=Categoria atualizada com sucesso!");
    } else {
        $categoriaModel->criar($dados);
        header("Location: CategoriaList.php?mensagem=Categoria criada com sucesso!");
    }
    exit();
}
?>

<h2><?php echo $tituloPagina; ?></h2>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" required
               value="<?php echo $categoria['nome'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea class="form-control" id="descricao" name="descricao"><?php echo $categoria['descricao'] ?? ''; ?></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="CategoriaList.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
