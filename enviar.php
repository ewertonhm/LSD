<?php
    session_start();
    if($_SESSION['logado'] != true){
        session_destroy();
        header('location:index.php');
    }
?>

<form enctype="multipart/form-data" action="recebido.php" method="POST">
    <!-- O Nome do elemento input determina o nome da array $_FILES -->
    Enviar esse arquivo: <input name="arquivo" type="file" />
    <br>
    <input type="submit" value="Enviar arquivo" />
</form>
