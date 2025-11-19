<?php
require_once __DIR__ . '/../../../../db.class.php';
require_once __DIR__ . '/../../../../header.php';

$pdo = DB::getInstance();
$q = $_GET['q'] ?? null;
if ($q) {
    $stmt = $pdo->prepare("SELECT p.*, c.nome as categoria, a.nome as autor FROM post p LEFT JOIN categorias c ON p.categoria_id=c.id LEFT JOIN autores a ON p.autor_id=a.id WHERE p.titulo LIKE :q OR p.descricao LIKE :q ORDER BY p.id DESC");
    $stmt->execute([':q' => "%$q%"]);
} else {
    $stmt = $pdo->query("SELECT p.*, c.nome as categoria, a.nome as autor FROM post p LEFT JOIN categorias c ON p.categoria_id=c.id LEFT JOIN autores a ON p.autor_id=a.id ORDER BY p.id DESC");
}
$posts = $stmt->fetchAll();
?>
<div class="mt-4">
  <div class="d-flex justify-content-between align-items-center">
    <h3>Artigos</h3>
    <a class="btn btn-success" href="PostForm.php">Novo Artigo</a>
  </div>

  <form class="my-3" method="get">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Buscar por título ou descrição" value="<?=htmlspecialchars($_GET['q'] ?? '')?>">
      <button class="btn btn-outline-secondary" type="submit">Buscar</button>
    </div>
  </form>

  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Título</th><th>Ano</th><th>Categoria</th><th>Autor</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach ($posts as $p): ?>
      <tr>
        <td><?=$p['id']?></td>
        <td><?=htmlspecialchars($p['titulo'])?></td>
        <td><?=htmlspecialchars($p['ano'])?></td>
        <td><?=htmlspecialchars($p['categoria'] ?? '-')?></td>
        <td><?=htmlspecialchars($p['autor'] ?? '-')?></td>
        <td>
          <a class="btn btn-sm btn-primary" href="PostForm.php?id=<?=$p['id']?>">Editar</a>
          <a class="btn btn-sm btn-danger" href="PostForm.php?acao=excluir&id=<?=$p['id']?>" onclick="return confirm('Confirma exclusão?')">Excluir</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php require_once __DIR__ . '/../../../../footer.php'; ?>
