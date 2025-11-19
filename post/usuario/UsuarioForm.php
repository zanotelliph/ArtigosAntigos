<?php


require_once 'UsuarioControle.php';

session_start();


if (isset($_SESSION['usuario_id'])) {
    header("Location: ../site/admin/index.php");
    exit();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuarioModel = new Usuario();
    $login = $_POST['login'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    $usuario = $usuarioModel->login($login, $senha);
    
    if ($usuario) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: ../site/admin/index.php");
        exit();
    } else {
        $erro = "Login ou senha inválidos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Artigos Antigos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">
                            <i class="fas fa-scroll"></i> Artigos Antigos
                        </h4>
                        
                        <?php if ($erro): ?>
                            <div class="alert alert-danger"><?php echo $erro; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="login" class="form-label">Usuário</label>
                                <input type="text" class="form-control" id="login" name="login" required 
                                       value="admin">
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required
                                       value="123">
                                <div class="form-text">Usuário: admin | Senha: 123</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>