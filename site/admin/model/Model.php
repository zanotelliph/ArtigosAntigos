<?php

require_once __DIR__ . '/../db.class.php';

class Model
{
    protected $db;
    protected $table;

    public function __construct($table)
    {
        $this->db = new Database();
        $this->table = $table;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->db->select($sql);
    }

    public function findById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->select($sql, [$id]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}
