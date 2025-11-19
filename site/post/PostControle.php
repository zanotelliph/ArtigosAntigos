<?php
require_once __DIR__ . '/../database/db.class.php';

class Post {
    protected $table = 'objetos';
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($dados) {
        $query = "INSERT INTO {$this->table} 
                  (titulo, conteudo, categoria_id, autor, data_publicacao) 
                  VALUES (:titulo, :conteudo, :categoria_id, :autor, :data_publicacao)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $dados['id'] = $id;
        $query = "UPDATE {$this->table} 
                  SET titulo = :titulo, conteudo = :conteudo, categoria_id = :categoria_id, autor = :autor, data_publicacao = :data_publicacao 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function buscar($termo) {
        $query = "SELECT o.*, c.nome as categoria_nome
                  FROM {$this->table} o
                  LEFT JOIN categorias c ON o.categoria_id = c.id
                  WHERE o.titulo LIKE :termo OR o.autor LIKE :termo
                  ORDER BY o.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['termo' => "%$termo%"]);
        return $stmt;
    }

    public function getAllWithCategory() {
        $query = "SELECT o.*, c.nome as categoria_nome
                  FROM {$this->table} o
                  LEFT JOIN categorias c ON o.categoria_id = c.id
                  ORDER BY o.id DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
