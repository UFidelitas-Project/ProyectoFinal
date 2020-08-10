<?php 
	session_start();
	include "../conexion.php"; 

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['idproveedor']) || empty($_POST['proveedor']) || empty($_POST['telefono']) || empty($_POST['direccion']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idproveedor= $_POST['idproveedor'];
			$proveedor = $_POST['proveedor'];
			$telefono  = $_POST['telefono'];
			$direccion   = $_POST['direccion'];

			$sql_update = mysqli_query($laconexion,"UPDATE proveedor
													SET proveedor='$proveedor',telefono='$telefono',direccion='$direccion'
												WHERE idproveedor= '$idproveedor' ");
		
			if($sql_update){
				$alert='<p class="msg_save">Proveedor actualizado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar el proveedor.</p>';
			}

		}

	}


	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_proveedor.php');
		mysqli_close($laconexion);
	}
	$idproveedor = $_REQUEST['id'];

	$sql= mysqli_query($laconexion,"SELECT idproveedor, proveedor, telefono, direccion FROM proveedor WHERE idproveedor = '$idproveedor' ");
	mysqli_close($laconexion);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_proveedor.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			
			$idproveedor = $data['idproveedor'];
			$proveedor = $data['proveedor'];
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
	<title>Actualizar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<div class="col-md-6">
				<h1>Actualizar proveedor</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="proveedor">Proveedor</label>
					<input class="form-control" type="text" name="proveedor" id="proveedor" placeholder="Proveedor" value="<?php echo $proveedor; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="telefono">Telefono</label>
					<input class="form-control" class="form-control" type="number" name="telefono" id="telefono" placeholder="Telefono" value="<?php echo $telefono; ?>">
				</div>
				<div class="form-group col-md-6">
					<label for="direccion">Dirección</label>
					<input class="form-control" type="text" name="direccion" id="direccion" placeholder="Dirección" value="<?php echo $direccion; ?>">
				</div>
				<div class="form-group col-md-6">
					<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
					<input class="btn btn-primary btn_save" type="submit" value="Actualizar proveedor">
				</div>
			</form>

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>