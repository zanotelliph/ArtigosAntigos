<?php

require_once 'Model.php';

class CategoriaModel extends Model
{
    public function __construct()
    {
        parent::__construct("categoria");
    }

    public function save($dados)
    {
        if (isset($dados['id']) && $dados['id'] > 0) {
            $sql = "UPDATE categoria SET nome = ? WHERE id = ?";
            return $this->db->execute($sql, [
                $dados['nome'],
                $dados['id']
            ]);
        } else {
            $sql = "INSERT INTO categoria (nome) VALUES (?)";
            return $this->db->execute($sql, [
                $dados['nome']
            ]);
        }
    }
}
