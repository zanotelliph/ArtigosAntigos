<?php
// categoria/CategoriaControle.php

require_once __DIR__ . '/../model/CategoriaModel.php';


class Categoria extends Model {
    protected $table = 'categorias';

    public function __construct() {
        parent::__construct();
    }

    public function criar($dados) {
        $query = "INSERT INTO " . $this->table . " (nome, descricao) VALUES (:nome, :descricao)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        $query = "UPDATE " . $this->table . " SET nome = :nome, descricao = :descricao WHERE id = :id";
        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function buscar($termo) {
        $query = "SELECT * FROM " . $this->table . " WHERE nome LIKE :termo OR descricao LIKE :termo";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['termo' => "%$termo%"]);
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