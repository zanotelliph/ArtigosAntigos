<?php
// post/PostControle.php

require_once '../site/admin/db.class.php';

class Post extends Model {
    // Nome da tabela correto e em minúsculo (como no banco)
    protected $table = 'objetos';
   public function criar($dados) {
    echo "<pre>";
    var_dump($dados);
    echo "</pre>";
    
    $query = "INSERT INTO " . $this->table . " 
             (nome, ano_fabricacao, categoria_id, usuario_id) 
             VALUES (:nome, :ano_fabricacao, :categoria_id, :usuario_id)";
    
    $stmt = $this->db->prepare($query);
    if ($stmt->execute($dados)) {
        echo "✔ Gravado com sucesso!";
    } else {
        echo "❌ Erro ao gravar!";
        print_r($stmt->errorInfo());
    }
    exit();
}

    public function atualizar($id, $dados) {
        $query = "UPDATE " . $this->table . " 
                 SET nome = :nome, ano_fabricacao = :ano_fabricacao, categoria_id = :categoria_id 
                 WHERE id = :id";
        
        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function buscar($termo) {
        $query = "SELECT a.*, c.nome as categoria_nome 
                 FROM " . $this->table . " a 
                 LEFT JOIN categorias c ON a.categoria_id = c.id 
                 WHERE a.nome LIKE :termo OR a.ano_fabricacao LIKE :termo
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
