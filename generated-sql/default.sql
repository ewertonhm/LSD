
BEGIN;

-----------------------------------------------------------------------
-- aluno
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "aluno" CASCADE;

CREATE TABLE "aluno"
(
    "codaluno" serial NOT NULL,
    "ra" INTEGER NOT NULL,
    "nome" VARCHAR(50) NOT NULL,
    PRIMARY KEY ("codaluno")
);

-----------------------------------------------------------------------
-- professor
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "professor" CASCADE;

CREATE TABLE "professor"
(
    "codprofessor" serial NOT NULL,
    "nome" VARCHAR(50) NOT NULL,
    PRIMARY KEY ("codprofessor")
);

-----------------------------------------------------------------------
-- trabalho
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "trabalho" CASCADE;

CREATE TABLE "trabalho"
(
    "codtrabalho" serial NOT NULL,
    "nome" VARCHAR(50) NOT NULL,
    "codaluno" INTEGER NOT NULL,
    "codprofessor" INTEGER NOT NULL,
    "url" VARCHAR(200),
    PRIMARY KEY ("codtrabalho")
);

-----------------------------------------------------------------------
-- versao
-----------------------------------------------------------------------

DROP TABLE IF EXISTS "versao" CASCADE;

CREATE TABLE "versao"
(
    "codversao" serial NOT NULL,
    "codtrabalho" INTEGER NOT NULL,
    "data" DATE NOT NULL,
    "hora" TIME NOT NULL,
    "descricao" TEXT NOT NULL,
    PRIMARY KEY ("codversao")
);

ALTER TABLE "trabalho" ADD CONSTRAINT "trabalho_codaluno_fkey"
    FOREIGN KEY ("codaluno")
    REFERENCES "aluno" ("codaluno");

ALTER TABLE "trabalho" ADD CONSTRAINT "trabalho_codprofessor_fkey"
    FOREIGN KEY ("codprofessor")
    REFERENCES "professor" ("codprofessor");

ALTER TABLE "versao" ADD CONSTRAINT "versao_codtrabalho_fkey"
    FOREIGN KEY ("codtrabalho")
    REFERENCES "trabalho" ("codtrabalho");

COMMIT;
