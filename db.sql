CREATE TABLE Aluno 
(
	codAluno SERIAL NOT NULL PRIMARY KEY,
	RA INT NOT NULL,
	nome VARCHAR(50) NOT NULL,
);

CREATE TABLE Professor
(
	codProfessor SERIAL NOT NULL PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
);

CREATE TABLE Trabalho
(
	codTrabalho SERIAL NOT NULL PRIMARY KEY,
	nome VARCHAR(50) NOT NULL,
	codAluno INT NOT NULL,
	codProfessor INT NOT NULL,
	url VARCHAR(200),
	FOREIGN KEY (codAluno) REFERENCES Aluno(codAluno),
	FOREIGN KEY (codProfessor) REFERENCES Professor(codProfessor)
	
);

CREATE TABLE Versao
(
	codVersao SERIAL NOT NULL PRIMARY KEY,
	codTrabalho INT NOT NULL,
	data DATE NOT NULL,
	hora TIME NOT NULL,
	descricao TEXT NOT NULL,
	FOREIGN KEY (codTrabalho) REFERENCES Trabalho(codTrabalho)
)

INSERT INTO Professor(nome)
VALUES ('Rodolfo'),('Roberto'),('Andre');











