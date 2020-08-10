<?php 
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$proveedor = $_POST['proveedor'];
			$telefono  = $_POST['telefono'];
			$direccion   = $_POST['direccion'];

			$query = mysqli_query($laconexion,"SELECT * FROM proveedor WHERE lower(proveedor) = lower('$proveedor') ");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El proveedor ya existe.</p>';
			}else{

				$query_insert = mysqli_query($laconexion,"INSERT INTO proveedor(proveedor,telefono,direccion)
																	VALUES('$proveedor','$telefono','$direccion')");
				if($query_insert){
					$alert='<p class="msg_save">Proveedor creado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el proveedor.</p>';
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
				<h1>Registro Proveedor</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="proveedor">Proveedor</label>
					<input class="form-control" type="text" name="proveedor" id="proveedor" placeholder="Proveedor">
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
					<input type="submit" value="Crear proveedor" class="btn btn-primary btn_save">
				</div>
			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>