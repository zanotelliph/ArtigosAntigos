<?php


require_once __DIR__ . '/UsuarioControle.php';
require_once __DIR__ . '/../admin/header.php';

redirectIfNotLoggedIn();

$usuarioModel = new Usuario();
$acao = $_GET['acao'] ?? 'listar';
$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 🔹 Agora inclui a senha (em branco caso não preencha)
    $dados = [
        'nome' => $_POST['nome'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'login' => $_POST['login'],
        'senha' => $_POST['senha'] ?? '' // 👈 importante!
    ];

    if ($acao === 'criar') {
        if ($usuarioModel->criar($dados)) {
            $mensagem = "Usuário criado com sucesso!";
            $acao = 'listar';
        }
    } elseif ($acao === 'editar') {
        $id = $_GET['id'];
        if ($usuarioModel->atualizar($id, $dados)) {
            $mensagem = "Usuário atualizado com sucesso!";
            $acao = 'listar';
        }
    }
}

if (isset($_GET['excluir'])) {
    if ($_GET['excluir'] != $_SESSION['usuario_id']) {
        if ($usuarioModel->delete($_GET['excluir'])) {
            $mensagem = "Usuário excluído com sucesso!";
        }
    } else {
        $mensagem = "Não é possível excluir seu próprio usuário!";
    }
}

if (isset($_GET['buscar'])) {
    $usuarios = $usuarioModel->buscar($_GET['termo']);
} else {
    $usuarios = $usuarioModel->getAll();
}

if ($acao === 'listar'):
?>
    <h2>Gerenciar Usuários do Sistema</h2>

    <?php if ($mensagem): ?>
        <div class="alert alert-info"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="../site/admin/index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="?acao=criar" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Usuário
        </a>
    </div>

    <form method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="termo" class="form-control" placeholder="Buscar usuários..." 
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
                    <th>Email</th>
                    <th>Login</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usuario = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['login']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['telefone']); ?></td>
                    <td class="table-actions">
                        <a href="?acao=editar&id=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                        <a href="?excluir=<?php echo $usuario['id']; ?>" class="btn btn-sm btn-danger" 
                           onclick="return confirm('Tem certeza?')">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

<?php elseif ($acao === 'criar' || $acao === 'editar'): ?>
    <h2><?php echo $acao === 'criar' ? 'Criar' : 'Editar'; ?> Usuário</h2>
    
    <?php
    $usuario = [];
    if ($acao === 'editar' && isset($_GET['id'])) {
        $usuario = $usuarioModel->getById($_GET['id']);
    }
    ?>

    <form method="POST" class="mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" required
                           value="<?php echo $usuario['nome'] ?? ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="text" class="form-control" id="telefone" name="telefone"
                           value="<?php echo $usuario['telefone'] ?? ''; ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?php echo $usuario['email'] ?? ''; ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input type="text" class="form-control" id="login" name="login" required
                           value="<?php echo $usuario['login'] ?? ''; ?>">
                </div>
            </div>
        </div>

        <?php if ($acao === 'criar'): ?>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
        </div>
        <?php else: ?>
        <div class="mb-3">
            <label for="senha" class="form-label">Nova senha (opcional)</label>
            <input type="password" class="form-control" id="senha" name="senha">
            <small class="form-text text-muted">Se deixado vazio, manterá a senha atual.</small>
        </div>
        <?php endif; ?>
        
        <button type="submit" class="btn btn-primary">Salvar</button>
        <a href="UsuarioList.php" class="btn btn-secondary">Cancelar</a>
    </form>
<?php endif; ?>

<?php
require_once __DIR__ . '/../admin/footer.php';
?>
