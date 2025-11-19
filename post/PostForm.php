<?php
require_once __DIR__ . '/../../../../db.class.php';
require_once __DIR__ . '/../../../../header.php';

$pdo = DB::getInstance();
$acao = $_GET['acao'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


if ($acao === 'excluir' && $id) {
    $stmt = $pdo->prepare("DELETE FROM post WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: PostList.php');
    exit;
}


$cats = $pdo->query("SELECT id, nome FROM categorias ORDER BY nome")->fetchAll();
$autores = $pdo->query("SELECT id, nome FROM autores ORDER BY nome")->fetchAll();

$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $ano = (int)($_POST['ano'] ?? 0);
    $categoria_id = !empty($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
    $descricao = trim($_POST['descricao']);
    $autor_id = !empty($_POST['autor_id']) ? (int)$_POST['autor_id'] : null;

    if (empty($titulo)) {
        $mensagem = 'Título é obrigatório.';
    } else {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE post SET titulo=:titulo, ano=:ano, categoria_id=:cid, descricao=:descricao, autor_id=:aid WHERE id=:id");
            $stmt->execute([':titulo'=>$titulo,':ano'=>$ano,':cid'=>$categoria_id,':descricao'=>$descricao,':aid'=>$autor_id,':id'=>$id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO post (titulo, ano, categoria_id, descricao, autor_id) VALUES (:titulo,:ano,:cid,:descricao,:aid)");
            $stmt->execute([':titulo'=>$titulo,':ano'=>$ano,':cid'=>$categoria_id,':descricao'=>$descricao,':aid'=>$autor_id]);
        }
        header('Location: PostList.php');
        exit;
    }
}

$post = null;
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM post WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    $post = $stmt->fetch();
}
?>
<div class="mt-4">
  <h3><?= $id ? 'Editar Artigo' : 'Novo Artigo' ?></h3>
  <?php if ($mensagem): ?><div class="alert alert-danger"><?=$mensagem?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3">
      <label class="form-label">Título</label>
      <input type="text" name="titulo" class="form-control" required value="<?=htmlspecialchars($post['titulo'] ?? '')?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Ano</label>
      <input type="number" name="ano" class="form-control" value="<?=htmlspecialchars($post['ano'] ?? '')?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Categoria</label>
      <select name="categoria_id" class="form-select">
        <option value="">-- Sem categoria --</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?=$c['id']?>" <?=isset($post['categoria_id']) && $post['categoria_id'] == $c['id'] ? 'selected' : ''?>><?=htmlspecialchars($c['nome'])?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Autor</label>
      <select name="autor_id" class="form-select">
        <option value="">-- Sem autor --</option>
        <?php foreach ($autores as $a): ?>
          <option value="<?=$a['id']?>" <?=isset($post['autor_id']) && $post['autor_id'] == $a['id'] ? 'selected' : ''?>><?=htmlspecialchars($a['nome'])?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Descrição</label>
      <textarea name="descricao" class="form-control" rows="6"><?=htmlspecialchars($post['descricao'] ?? '')?></textarea>
    </div>
    <button class="btn btn-success" type="submit">Salvar</button>
    <a class="btn btn-secondary" href="PostList.php">Cancelar</a>
  </form>
</div>
<?php require_once __DIR__ . '/../../../../footer.php'; ?>
