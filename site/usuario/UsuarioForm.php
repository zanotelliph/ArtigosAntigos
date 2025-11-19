<?php
require_once __DIR__ . '/UsuarioControle.php';
require_once __DIR__ . '/../admin/header.php';

redirectIfNotLoggedIn();

$acao = $_GET['acao'] ?? 'criar';
$usuarioModel = new Usuario();
$id = $_GET['id'] ?? null;
$usuario = [];

if ($acao === 'editar' && $id) {
    $usuario = $usuarioModel->getById($id);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'login' => $_POST['login'],
        'senha' => $_POST['senha'] ?? ''
    ];

    if ($acao === 'criar') {
        $usuarioModel->criar($dados);
        header("Location: UsuarioList.php?mensagem=Usuário criado com sucesso!");
    } elseif ($acao === 'editar') {
        $usuarioModel->atualizar($id, $dados);
        header("Location: UsuarioList.php?mensagem=Usuário atualizado com sucesso!");
    }
    exit();
}
?>

<h2><?php echo $acao === 'criar' ? 'Criar Usuário' : 'Editar Usuário'; ?></h2>

<form method="POST" class="mt-3">
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" class="form-control" name="nome" required value="<?php echo $usuario['nome'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label>Telefone</label>
        <input type="text" class="form-control" name="telefone" value="<?php echo $usuario['telefone'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required value="<?php echo $usuario['email'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label>Login</label>
        <input type="text" class="form-control" name="login" required value="<?php echo $usuario['login'] ?? ''; ?>">
    </div>
    <div class="mb-3">
        <label><?php echo $acao === 'criar' ? 'Senha' : 'Nova senha (opcional)'; ?></label>
        <input type="password" class="form-control" name="senha">
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="UsuarioList.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../admin/footer.php'; ?>
