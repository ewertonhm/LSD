<?php
  require_once 'config.php';

  $recebido = $_FILES["arquivo"];
  $diretorio = "trabs/";

  $usuarioQ = new UsuarioQuery();
  $usuario = $usuarioQ->findOneByLogin('admin');
  $aluno = $usuario->getAlunos();
  $professor = $usuario->getProfessors();
  $nome = '';

  if($aluno->isEmpty()){
    $nome = $professor[0]->getNome();
  } else {
    $nome = $aluno[0]->getNome();
  }

 //mover arquivo da pasta temporaria para pasta de destino
if(move_uploaded_file($recebido["tmp_name"], "$diretorio/$nome/")){
  echo "enviado com sucesso!";
}
else {
  echo "deu erro krl";
}
?>
