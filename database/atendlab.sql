DROP DATABASE IF EXISTS atendlab;
CREATE DATABASE atendlab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE atendlab;


CREATE TABLE usuarios(
    id_usuarios INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin','atendente', 'aluno') DEFAULT 'atendente',
    status ENUM('ativo','inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pessoas(
    id_pessoas INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(100),
    documento VARCHAR(20) UNIQUE,
    telefone VARCHAR(20),
    curso VARCHAR(100),
    periodo VARCHAR(100),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo' 
);

CREATE TABLE tipos_atendimentos(
    id_tipo_atendimento INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE atendimentos(
    id_atendimentos INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    id_usuarios INT NOT NULL,
    id_pessoas INT NOT NULL,
    id_tipo_atendimento INT NOT NULL,
    FOREIGN KEY (id_usuarios) REFERENCES usuarios(id_usuarios),
    FOREIGN KEY (id_pessoas) REFERENCES pessoas(id_pessoas),
    FOREIGN KEY (id_tipo_atendimento) REFERENCES tipos_atendimentos(id_tipo_atendimento),
    data_atendimento DATE,
    hora_atendimento TIME,
    descricao TEXT,
    observacao TEXT,
    status ENUM('aberto','em atendimento','concluido','cancelado') DEFAULT 'aberto',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha, perfil, status)
VALUES (
'Administrador',
'admin@atendelab.com',
'123456',
'admin',
'ativo'
);