<?php 
	session_start();
	include "../conexion.php";
 
	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['contraseña']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$nombre = $_POST['nombre'];
			$email  = $_POST['correo'];
			$user   = $_POST['usuario'];
			$contraseña  = md5($_POST['contraseña']);


			$query = mysqli_query($laconexion,"SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email' ");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				$query_insert = mysqli_query($laconexion,"INSERT INTO usuario(nombre,correo,usuario,contraseña)
																	VALUES('$nombre','$email','$user','$contraseña')");
				if($query_insert){
					$alert='<p class="msg_save">Usuario creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el usuario.</p>';
				}
				mysqli_close($laconexion);

			}


		}

	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register" >
			<div class="col-md-6">
				<br>
				<h1>Registro usuario</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="nombre">Nombre</label>
					<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre completo">
				</div>
				<div class="form-group col-md-6">
					<label for="correo">Correo electrónico</label>
					<input class="form-control" type="email" name="correo" id="correo" placeholder="Correo electrónico">
				</div>
				<div class="form-group col-md-6">
					<label for="usuario">Usuario</label>
					<input class="form-control" type="text" name="usuario" id="usuario" placeholder="Usuario">
				</div>
				<div class="form-group col-md-6">
					<label for="contraseña">Contraseña</label>
					<input class="form-control" type="password" name="contraseña" id="contraseña" placeholder="Contraseña">
				</div>
				<div class="form-group col-md-6">
					<input type="submit" value="Crear usuario" class="btn btn-primary btn_save center">
				</div>
			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>