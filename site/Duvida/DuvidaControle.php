<?php
require_once __DIR__ . '/../model/DuvidaModel.php';

class Duvida {
    protected $table = 'duvidas';
    private $db;

    public function __construct() {
        $this->db = new DuvidaModel();
    }

    public function criar($dados) {
        return $this->db->save($dados);
    }

    public function atualizar($id, $dados) {
        $dados['id'] = $id;
        return $this->db->save($dados);
    }

    public function getAll() {
        return $this->db->findAll();
    }

    public function getById($id) {
        $result = $this->db->findById($id);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        return $this->db->delete($id);
    }
}
?>
