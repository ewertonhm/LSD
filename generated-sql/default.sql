
BEGIN;

-----------------------------------------------------------------------
-- aluno
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "aluno" CASCADE;

CREATE TABLE "aluno"
(
    "id" serial NOT NULL,
    "nome" VARCHAR(60),
    "endereco" VARCHAR(120),
    "telefone" VARCHAR(16),
    "usuario_id" INTEGER,
    "curso_id" INTEGER,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- curso
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "curso" CASCADE;

CREATE TABLE "curso"
(
    "id" serial NOT NULL,
    "nome" VARCHAR(120),
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- professor
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "professor" CASCADE;

CREATE TABLE "professor"
(
    "id" serial NOT NULL,
    "nome" VARCHAR(60),
    "endereco" VARCHAR(120),
    "telefone" VARCHAR(16),
    "usuario_id" INTEGER,
    "curso_id" INTEGER,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- trabalho
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "trabalho" CASCADE;

CREATE TABLE "trabalho"
(
    "id" serial NOT NULL,
    "data" DATE,
    "caminho_arquivo" VARCHAR(255),
    "comentario" VARCHAR(500),
    "usuario_id" INTEGER,
    "professor_id" INTEGER,
    PRIMARY KEY ("id")
);

-----------------------------------------------------------------------
-- usuario
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "usuario" CASCADE;

CREATE TABLE "usuario"
(
    "id" serial NOT NULL,
    "login" VARCHAR(45) NOT NULL,
    "senha" VARCHAR(32) NOT NULL,
    "email" VARCHAR(45) NOT NULL,
    "admin" INTEGER,
    PRIMARY KEY ("id")
);

ALTER TABLE "aluno" ADD CONSTRAINT "aluno_curso_id_fkey"
    FOREIGN KEY ("curso_id")
    REFERENCES "curso" ("id");

ALTER TABLE "aluno" ADD CONSTRAINT "aluno_usuario_id_fkey"
    FOREIGN KEY ("usuario_id")
    REFERENCES "usuario" ("id");

ALTER TABLE "professor" ADD CONSTRAINT "professor_curso_id_fkey"
    FOREIGN KEY ("curso_id")
    REFERENCES "curso" ("id");

ALTER TABLE "professor" ADD CONSTRAINT "professor_usuario_id_fkey"
    FOREIGN KEY ("usuario_id")
    REFERENCES "usuario" ("id");

ALTER TABLE "trabalho" ADD CONSTRAINT "trabalho_professor_id_fkey"
    FOREIGN KEY ("professor_id")
    REFERENCES "professor" ("id");

ALTER TABLE "trabalho" ADD CONSTRAINT "trabalho_usuario_id_fkey"
    FOREIGN KEY ("usuario_id")
    REFERENCES "usuario" ("id");

COMMIT;
