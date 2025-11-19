<?php
require_once __DIR__ . '/UsuarioControle.php';
require_once __DIR__ . '/../admin/header.php';


redirectIfNotLoggedIn();

$usuarioModel = new Usuario();

if (isset($_GET['excluir'])) {
    if ($_GET['excluir'] != $_SESSION['usuario_id']) {
        $usuarioModel->delete($_GET['excluir']);
        $mensagem = "Usuário excluído com sucesso!";
    } else {
        $mensagem = "Não é possível excluir seu próprio usuário!";
    }
}

$usuarios = $usuarioModel->getAll();
?>

<h2>Gerenciar Usuários</h2>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-info"><?php echo $mensagem; ?></div>
<?php endif; ?>

<a href="UsuarioForm.php?acao=criar" class="btn btn-primary mb-3">Novo Usuário</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Login</th>
            <th>Telefone</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($u = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo htmlspecialchars($u['nome']); ?></td>
            <td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><?php echo htmlspecialchars($u['login']); ?></td>
            <td><?php echo htmlspecialchars($u['telefone']); ?></td>
            <td>
                <a href="UsuarioForm.php?acao=editar&id=<?php echo $u['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                <a href="?excluir=<?php echo $u['id']; ?>" onclick="return confirm('Tem certeza?')" class="btn btn-danger btn-sm">Excluir</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
