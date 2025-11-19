<?php
require_once __DIR__ . '/../database/db.class.php';

class Usuario {
    protected $table = 'usuarios';
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function criar($dados) {
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        $query = "INSERT INTO {$this->table} (nome, telefone, email, login, senha) 
                  VALUES (:nome, :telefone, :email, :login, :senha)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        if (!empty($dados['senha'])) {
            $query = "UPDATE {$this->table} 
                      SET nome = :nome, telefone = :telefone, email = :email, login = :login, senha = :senha
                      WHERE id = :id";
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        } else {
            $query = "UPDATE {$this->table} 
                      SET nome = :nome, telefone = :telefone, email = :email, login = :login
                      WHERE id = :id";
            unset($dados['senha']);
        }
        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function login($login, $senha) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE login = ?");
        $stmt->execute([$login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} ORDER BY id DESC");
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
