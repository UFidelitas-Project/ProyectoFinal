<?php 
session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idcliente = $_POST['idcliente'];

		$query_delete = mysqli_query($laconexion,"UPDATE cliente SET estatus = 0 WHERE idcliente = $idcliente ");
		mysqli_close($laconexion);
		if($query_delete){
			header("location: lista_cliente.php");
		}else{
			echo "Error al eliminar";
		}

	}

 
	if(empty($_REQUEST['id']))
	{
		header("location: lista_cliente.php");
		mysqli_close($laconexion);
	}else{

		$idcliente = $_REQUEST['id'];

		$query = mysqli_query($laconexion,"SELECT idcliente, cedula, nombre, telefono, direccion FROM cliente
												WHERE idcliente= '$idcliente' ");
		
		mysqli_close($laconexion);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				$cedula = $data['cedula'];
				$nombre = $data['nombre'];
				$telefono     = $data['telefono'];
				$direccion = $data['direccion'];
			}
		}else{
			header("location: lista_cliente.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Cliente</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente cliente?</h2>
			<p>Cedula: <span><?php echo $cedula; ?></span></p>
			<p>Nombre: <span><?php echo $nombre; ?></span></p>
			<p>Telefono: <span><?php echo $telefono; ?></span></p>
			<p>Dirección: <span><?php echo $direccion; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idcliente" value="<?php echo $idcliente; ?>">
				<a class="btn btn-danger" href="lista_cliente.php" class="btn_cancel">Cancelar</a>
				<input class="btn btn-success" type="submit" value="Aceptar" >
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>