<?php
    session_start();
    if($_SESSION['logado'] != true){
        session_destroy();
        header('location:index.php');
    }
    require_once("html/cabecalhoaluno.html");
?>

<div class="container mt-3">
  <h2>Anexar</h2>
  <form action="recebido.php">
    <p>Anexar TCC:</p>
    <div class="custom-file mb-1">
      <input type="file" class="custom-file-input" id="customFile" name="filename">
      <label class="custom-file-label" for="customFile">Selecionar Arquivo</label>
    </div>
    
    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
  </form>
</div>

<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
