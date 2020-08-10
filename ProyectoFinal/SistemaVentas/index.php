<?php 
	
$alert = '';
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{

	if(!empty($_POST))
	{
		if(empty($_POST['usuario']) || empty($_POST['contraseña']))
		{
			$alert = 'Ingrese su usuario y su contraseña';
		}else{

			require_once "conexion.php";

			$user = mysqli_real_escape_string($laconexion,$_POST['usuario']);
			$pass = mysqli_real_escape_string($laconexion,$_POST['contraseña']);

			$query = mysqli_query($laconexion,"SELECT * FROM usuario WHERE usuario= '$user' AND contraseña = '$pass'");
			mysqli_close($laconexion);
			$result = mysqli_num_rows($query);

			if($result > 0)
			{
				$data = mysqli_fetch_array($query);
				$_SESSION['active'] = true;
				$_SESSION['idUser'] = $data['idusuario'];
				$_SESSION['nombre'] = $data['nombre'];
				$_SESSION['email']  = $data['email'];
				$_SESSION['user']   = $data['usuario'];

				header('location: sistema/');
			}else{
				$alert = 'El usuario o la contraseña son incorrectos';
				session_destroy();
			}


		}

	}
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login | Sistema Facturación</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<section id="container">
		
		<form action="" method="post">
			<br>
			<h3>Iniciar Sesión</h3>

			<input type="text" name="usuario" placeholder="Usuario">
			<input type="password" name="contraseña" placeholder="Contraseña">
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			<input type="submit" value="INGRESAR">

		</form>

	</section>
</body>
</html>