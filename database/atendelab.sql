CREATE DATABASE IF NOT EXISTS atendelab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE atendelab;

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'atendente') DEFAULT 'atendente',
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/* TESTE DA TABELA USUARIO */
INSERT INTO usuarios (nome, email, senha, perfil, status)
VALUES (
    'Administrador',
    'admin@atendelab.com',
    '$2y$10$J9P2kU2BAMZ3TZcuxTsW4e1D/lka8EocYHzvyoOZmCNcWDQz3RuVC',
    'admin',
    'ativo'
);

CREATE TABLE pessoas (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    documento VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    curso VARCHAR(100) NOT NULL,
    periodo VARCHAR(100) NOT NULL,
    status VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/* TESTE DA TABELA PESSOAS */
INSERT INTO pessoas (nome, documento, email, telefone, curso, periodo, status)
VALUES (
    'Matheus',
    'documento',
    'matheus@gmail.com',
    '+55 (47)11223-4456',
    'engenharia de software',
    '5º Semestre',
    'ativo'
);

CREATE TABLE tipo_atendimento (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/* TESTE DA TABELA TIPO_ATENDIMENTO */
INSERT INTO tipo_atendimento (nome, descricao, status)
VALUES (
    'Boletim',
    'Solicitação de boletim escolar',
    'ativo'
)

CREATE TABLE atendimentos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipo_atendimento INT NOT NULL,
    id_pessoa INT NOT NULL,
    id_usuario INT NOT NULL,
    data_atendimento DATE NOT NULL,
    hora_atendimento TIME NOT NULL,
    descricao TEXT NOT NULL,
    observacao_final TEXT NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_atendimentos_tipo_atendimento
        FOREIGN KEY(id_tipo_atendimento) REFERENCES tipo_atendimento(id),
    CONSTRAINT fk_atendimentos_pessoas
        FOREIGN KEY(id_pessoa) REFERENCES pessoas(id),
    CONSTRAINT fk_atendimentos_usuarios
        FOREIGN KEY(id_usuario) REFERENCES usuarios(id)
);
/* TESTE DA TABELA ATENDIMENTOS */
INSERT INTO atendimentos (id_tipo_atendimento, id_pessoa, id_usuario, data_atendimento, hora_atendimento, descricao, observacao_final, status)
VALUES (
    1,
    1,
    1,
    '2026-06-09',
    '20:58:00',
    'Solicitação de boletim escolar',
    'Solicitação completa e documento enviado',
    'inativo'
)