-- database/db.artigos.sql

CREATE DATABASE IF NOT EXISTS artigos_antigos;
USE artigos_antigos;

-- Tabela de usuários
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100) UNIQUE NOT NULL,
    login VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de categorias
CREATE TABLE categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de artigos (posts)
CREATE TABLE artigos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200) NOT NULL,
    conteudo TEXT NOT NULL,
    data_publicacao DATE NOT NULL,
    autor VARCHAR(100) NOT NULL,
    categoria_id INT,
    usuario_id INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Inserir usuário padrão (senha: 123)
INSERT INTO usuarios (nome, email, login, senha) VALUES 
('Administrador', 'admin@email.com', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Inserir categorias iniciais
INSERT INTO categorias (nome, descricao) VALUES 
('História Antiga', 'Artigos sobre civilizações antigas'),
('Arqueologia', 'Descobertas e estudos arqueológicos'),
('Documentos Históricos', 'Análise de documentos antigos');
