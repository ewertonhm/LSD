<?php

$conexao = pg_connect("host=192.168.1.221 port=5432 dbname=social user=postgres password=A1cdl33$3") or die ("Não foi possivel conectar ao servidor POSTGRESQL");
//caso a conexão seja efetuada com sucesso, exibe uma mensagem ao usuario
echo "Conexão efetuada com sucesso!!";

?>