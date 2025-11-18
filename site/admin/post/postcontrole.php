<?php
// post/PostControle.php

require_once '../site/admin/db.class.php';

class Post extends Model {
    protected $table = 'artigos';

    public function __construct() {
        parent::__construct();
    }

    public function criar($dados) {
        $query = "INSERT INTO " . $this->table . " 
                 (titulo, conteudo, data_publicacao, autor, categoria_id, usuario_id) 
                 VALUES (:titulo, :conteudo, :data_publicacao, :autor, :categoria_id, :usuario_id)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $query = "UPDATE " . $this->table . " 
                 SET titulo = :titulo, conteudo = :conteudo, data_publicacao = :data_publicacao, 
                     autor = :autor, categoria_id = :categoria_id 
                 WHERE id = :id";
        
        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function buscar($termo) {
        $query = "SELECT a.*, c.nome as categoria_nome 
                 FROM " . $this->table . " a 
                 LEFT JOIN categorias c ON a.categoria_id = c.id 
                 WHERE a.titulo LIKE :termo OR a.conteudo LIKE :termo OR a.autor LIKE :termo 
                 ORDER BY a.id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute(['termo' => "%$termo%"]);
        return $stmt;
    }

    public function getAllWithCategory() {
        $query = "SELECT a.*, c.nome as categoria_nome 
                 FROM " . $this->table . " a 
                 LEFT JOIN categorias c ON a.categoria_id = c.id 
                 ORDER BY a.id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>