<?php

require_once 'Model.php';

class UsuarioModel extends Model
{
    public function __construct()
    {
        parent::__construct("usuario");
    }

    public function save($dados)
    {
        if (isset($dados['id']) && $dados['id'] > 0) {
            $sql = "UPDATE usuario SET nome = ?, email = ?, senha = ? WHERE id = ?";
            return $this->db->execute($sql, [
                $dados['nome'],
                $dados['email'],
                $dados['senha'],
                $dados['id']
            ]);
        } else {
            $sql = "INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)";
            return $this->db->execute($sql, [
                $dados['nome'],
                $dados['email'],
                $dados['senha']
            ]);
        }
    }
}
