<?php

require_once 'Model.php';

class PostModel extends Model
{
    public function __construct()
    {
        parent::__construct("post");
    }

    public function save($dados)
    {
        if (isset($dados['id']) && $dados['id'] > 0) {
            $sql = "UPDATE post SET titulo = ?, conteudo = ?, categoria_id = ? WHERE id = ?";
            return $this->db->execute($sql, [
                $dados['titulo'],
                $dados['conteudo'],
                $dados['categoria_id'],
                $dados['id']
            ]);
        } else {
            $sql = "INSERT INTO post (titulo, conteudo, categoria_id) VALUES (?, ?, ?)";
            return $this->db->execute($sql, [
                $dados['titulo'],
                $dados['conteudo'],
                $dados['categoria_id']
            ]);
        }
    }
}
