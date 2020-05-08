insert into usuario (login,senha,email) values ('admin','admin','admin@test.com');
insert into curso (nome) values ('Sistemas de Informação');
insert into professor (nome,endereco,telefone,usuario_id,curso_id) values ('Administrador','Rua tatata','654564564',1,1);

insert into usuario (login,senha,email) values ('aluno','aluno','admin@test.com');
insert into aluno (nome, endereco, telefone, usuario_id, curso_id, versao) values ('Aluno','Rua qqrcoisa','4654564',2,1,0);
