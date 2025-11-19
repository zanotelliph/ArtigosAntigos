<?php
require_once 'DuvidaControle.php';
require_once '../admin/header.php';

redirectIfNotLoggedIn();

$duvidaModel = new Duvida();

$id = $_GET['id'] ?? null;
$duvida = [];
$tituloPagina = $id ? 'Editar Dúvida' : 'Cadastrar Dúvida';

if ($id) {
    $duvida = $duvidaModel->getById($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'titulo' => $_POST['titulo'],
        'conteudo' => $_POST['conteudo'],
        'usuario_id' => $_SESSION['usuario_id']
    ];

    if ($id) {
        $duvidaModel->atualizar($id, $dados);
        header("Location: DuvidaList.php?mensagem=Dúvida atualizada com sucesso!");
    } else {
        $duvidaModel->criar($dados);
        header("Location: DuvidaList.php?mensagem=Dúvida criada com sucesso!");
    }
    exit();
}
?>

<h2><?php echo $tituloPagina; ?></h2>

<form method="POST">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" class="form-control" id="titulo" name="titulo" required
               value="<?php echo $duvida['titulo'] ?? ''; ?>">
    </div>

    <div class="mb-3">
        <label for="conteudo" class="form-label">Conteúdo</label>
        <textarea class="form-control" id="conteudo" name="conteudo" rows="5" required><?php echo $duvida['conteudo'] ?? ''; ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="DuvidaList.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once '../admin/footer.php'; ?>
