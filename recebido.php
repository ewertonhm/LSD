<?php
  require_once 'config.php';

  $recebido = $_FILES["arquivo"];
  $diretorio = "trabs/";

 //mover arquivo da pasta temporaria para pasta de destino
if(move_uploaded_file($recebido["tmp_name"], "$diretorio/$nome/")){
  echo "enviado com sucesso!";
}
else {
  echo "deu erro krl";
}
?>
