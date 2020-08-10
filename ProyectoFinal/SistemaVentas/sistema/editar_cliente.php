<?php 
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['idcliente']) || empty($_POST['nombre']) || empty($_POST['telefono']) || empty($_POST['direccion']) || empty($_POST['cedula']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idcliente = $_POST['idcliente'];
			$cedula = $_POST['cedula'];
			$nombre = $_POST['nombre'];
			$telefono  = $_POST['telefono'];
			$direccion   = $_POST['direccion'];

			$sql_update = mysqli_query($laconexion,"UPDATE cliente
													SET cedula = '$cedula', nombre='$nombre',telefono='$telefono',direccion='$direccion'
												WHERE idcliente= $idcliente");
		
			if($sql_update){
				$alert='<p class="msg_save">Cliente actualizado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar el cliente.</p>';
			}

		}

	}


	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_cliente.php');
		mysqli_close($laconexion);
	}
	$idcliente = $_REQUEST['id'];

	$sql= mysqli_query($laconexion,"SELECT idcliente, cedula, nombre, telefono, direccion FROM cliente WHERE idcliente = '$idcliente' ");
	mysqli_close($laconexion);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_cliente.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			
			$idcliente = $data['idcliente'];
			$cedula = $data['cedula'];
			$nombre = $data['nombre'];
			$telefono = $data['telefono'];
			$direccion = $data['direccion'];
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container"> 
		
		<div class="form_register">
			<div class="col-md-6">
				<h1>Actualizar cliente</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="cedula">Cedula</label>
					<input class="form-control" type="number" name="cedula" id="cedula" placeholder="Cedula" value="<?php echo $cedula; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="nombre">Nombre</label>
					<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="telefono">Telefono</label>
					<input class="form-control" type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="direccion">Dirección</label>
					<input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				</div>
				<div class="form-group col-md-6">
					<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
					<input class="btn btn-primary btn_save" type="submit" value="Actualizar cliente" ">
				</div>
				</form>

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>