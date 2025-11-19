<?php
require_once __DIR__ . '/../database/db.class.php';


class Categoria {
    protected $table = 'categorias';
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($dados) {
        $query = "INSERT INTO {$this->table} (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $dados['id'] = $id;
        $query = "UPDATE {$this->table} SET nome = :nome, descricao = :descricao WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id DESC";
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
