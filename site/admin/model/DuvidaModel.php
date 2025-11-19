<?php
require_once 'Model.php';

class DuvidaModel extends Model {
    public function __construct() {
        parent::__construct("duvidas");
    }

    public function save($dados) {
        if (isset($dados['id']) && $dados['id'] > 0) {
            $sql = "UPDATE duvidas SET titulo = ?, conteudo = ? WHERE id = ?";
            return $this->db->prepare($sql)->execute([
                $dados['titulo'],
                $dados['conteudo'],
                $dados['id']
            ]);
        } else {
            $sql = "INSERT INTO duvidas (titulo, conteudo, usuario_id) VALUES (?, ?, ?)";
            return $this->db->prepare($sql)->execute([
                $dados['titulo'],
                $dados['conteudo'],
                $dados['usuario_id']
            ]);
        }
    }
}
?>
