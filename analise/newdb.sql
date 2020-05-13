CREATE TABLE usuario (
    id SERIAL PRIMARY KEY,
    senha VARCHAR(32) NOT NULL,
    email VARCHAR(45) NOT NULL,
    admin INT
);

CREATE TABLE curso (
    id SERIAL PRIMARY KEY NOT NULL,
    nome VARCHAR(120)
);

CREATE TABLE professor (
    id SERIAL PRIMARY KEY NOT NULL,
    nome VARCHAR(60),
    endereco VARCHAR(120),
    telefone VARCHAR(16),
    usuario_id INT REFERENCES usuario(id),
    curso_id INT REFERENCES curso(id)
);

CREATE TABLE aluno (
    id SERIAL PRIMARY KEY NOT NULL,
    nome VARCHAR(60),
    endereco VARCHAR(120),
    telefone VARCHAR(16),
    usuario_id INT REFERENCES usuario(id),
    curso_id INT REFERENCES curso(id),
    versao INT
);

CREATE TABLE trabalho (
    id SERIAL PRIMARY KEY NOT NULL,
    data DATE,
    caminho_arquivo VARCHAR(255),
    comentario VARCHAR(500),
    usuario_id INT REFERENCES usuario(id),
    professor_id INT REFERENCES professor(id)
);


