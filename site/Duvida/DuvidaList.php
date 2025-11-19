<?php
require_once 'DuvidaControle.php';
require_once '../admin/header.php';

redirectIfNotLoggedIn();

$duvidaModel = new Duvida();

if (isset($_GET['excluir'])) {
    $duvidaModel->delete($_GET['excluir']);
    $mensagem = "Dúvida excluída com sucesso!";
}

$duvidas = $duvidaModel->getAll();
?>

<h2>Gerenciar Dúvidas</h2>

<?php if (!empty($_GET['mensagem'])): ?>
    <div class="alert alert-success"><?php echo $_GET['mensagem']; ?></div>
<?php endif; ?>

<a href="DuvidaForm.php" class="btn btn-primary mb-3">Nova Dúvida</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($duvida = $duvidas->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $duvida['id']; ?></td>
            <td><?php echo htmlspecialchars($duvida['titulo']); ?></td>
            <td><?php echo htmlspecialchars($duvida['conteudo']); ?></td>
            <td>
                <a href="DuvidaForm.php?id=<?php echo $duvida['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <a href="?excluir=<?php echo $duvida['id']; ?>" onclick="return confirm('Tem certeza?')" class="btn btn-danger btn-sm">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once '../admin/footer.php'; ?>
