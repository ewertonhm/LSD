<?php
  require_once "Classes/db/DBConexao.php";
  $recebido = $_FILES["arquivo"];
  $diretorio = "arquivoUpado/";

 //mover arquivo da pasta temporaria para pasta de destino
if(move_uploaded_file($recebido["tmp_name"], "$diretorio/".$recebido["name"])){
  echo "enviado com sucesso!";
}
else {
  echo "deu erro krl";
}

?>
