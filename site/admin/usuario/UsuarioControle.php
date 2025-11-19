<?php
require_once __DIR__ . '/../database/db.class.php';

class Usuario extends Model {
    protected $table = 'usuarios';

    public function __construct() {
        parent::__construct();
    }

    public function criar($dados) {
        $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table . " 
                 (nome, telefone, email, login, senha) 
                 VALUES (:nome, :telefone, :email, :login, :senha)";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function atualizar($id, $dados) {
        // 🔹 Se o campo senha for preenchido, atualiza também a senha
        if (!empty($dados['senha'])) {
            $query = "UPDATE {$this->table} 
                      SET nome = :nome, telefone = :telefone, email = :email, login = :login, 
                          senha = :senha
                      WHERE id = :id";

            // Criptografa a nova senha
            $dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);

        } else {
            // 🔹 Se a senha estiver vazia, mantém a senha atual
            $query = "UPDATE {$this->table} 
                      SET nome = :nome, telefone = :telefone, email = :email, login = :login
                      WHERE id = :id";

            // Remove para não interferir no execute
            unset($dados['senha']);
        }

        $dados['id'] = $id;
        $stmt = $this->db->prepare($query);
        return $stmt->execute($dados);
    }

    public function login($login, $senha) {
        $query = "SELECT * FROM " . $this->table . " WHERE login = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$login]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }
        return false;
    }

    public function buscar($termo) {
        $query = "SELECT * FROM " . $this->table . " 
                 WHERE nome LIKE :termo OR email LIKE :termo OR login LIKE :termo";
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
