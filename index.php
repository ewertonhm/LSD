<?php
    require_once 'config.php';

    if (isset($_POST['btn-login'])){
        $usuario = UsuarioQuery::create()->findOneByEmail($_POST['login']);
        if($usuario != null){
            if($usuario->getSenha() == md5($_POST['senha'])){
                session_start();
                $_SESSION['logado'] = true;
                $_SESSION['id'] = $usuario->getId();
                header('location:dashboard.php');
            } else {
                echo "senha errada jão";
            }
        } else {
            echo "senha errada jão";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>

	<title>Login</title>
  
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/login.css">

</head>
<body>
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card border border-dark">
			<div class="card-header text-center">
				<p class=""><h5>LOGIN</h5></p>
			</div>
			<div class="card-body">
				<form action="index.php" method="post">
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary "><i class="fas fa-user"></i></span>
						</div>
						<input type="text" name="login" class="form-control border border-dark" placeholder="Email">
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text bg-primary "><i class="fas fa-key"></i></span>
						</div>
						<input type="password" name="senha" class="form-control border border-dark" placeholder="Senha">
					</div>
					<div class="form-group">
						<input type="submit" name="btn-login" value="LOGIN" class=" btn btn-primary form-control border border-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>
</html>