<?php
// post/PostControle.php

require_once __DIR__ . '/../db.class.php';

class Post extends Model {
    protected $table = 'objetos';

    public function criar($dados) {
        $query = "INSERT INTO {$this->table} 
                 (nome, ano_fabricacao, categoria_id, usuario_id) 
                 VALUES (:nome, :ano_fabricacao, :categoria_id, :usuario_id)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $query = "UPDATE {$this->table} 
                 SET nome = :nome, ano_fabricacao = :ano_fabricacao, categoria_id = :categoria_id 
                 WHERE id = :id";
        
        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function buscar($termo) {
        $query = "SELECT o.*, c.nome as categoria_nome 
                 FROM {$this->table} o 
                 LEFT JOIN categorias c ON o.categoria_id = c.id 
                 WHERE o.nome LIKE :termo OR o.ano_fabricacao LIKE :termo
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
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
