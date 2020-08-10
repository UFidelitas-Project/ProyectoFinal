<?php 
	session_start();
	include "../conexion.php"; 

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['cedula']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$cedula = $_POST['cedula'];
			$nombre = $_POST['nombre'];
			$telefono  = $_POST['telefono'];
			$direccion   = $_POST['direccion'];

			$query = mysqli_query($laconexion,"SELECT * FROM cliente WHERE cedula = '$cedula' ");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El cliente ya existe.</p>';
			}else{

				$query_insert = mysqli_query($laconexion,"INSERT INTO cliente(cedula,nombre,telefono,direccion)
																	VALUES('$cedula','$nombre','$telefono','$direccion')");
				if($query_insert){
					$alert='<p class="msg_save">Usuario creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el usuario.</p>';
				}

			}


		}

	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<div class="col-md-6">
				<h1>Registro Cliente</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="cedula">Cedula</label>
					<input class="form-control" type="number" name="cedula" id="cedula" placeholder="Cedula">
				</div>
				<div class="form-group col-md-6">
					<label for="nombre">Nombre</label>
					<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre completo">
				</div>
				<div class="form-group col-md-6">
					<label for="telefono">Telefono</label>
					<input class="form-control" type="number" name="telefono" id="telefono" placeholder="Telefono">
				</div>
				<div class="form-group col-md-6">
					<label for="direccion">Dirección</label>
					<input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección">
				</div>
					<div class="form-group col-md-6">
					<input type="submit" value="Crear cliente" class="btn btn-primary btn_save">
				</div>
			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>