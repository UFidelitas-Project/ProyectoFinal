<?php 
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idproveedor = $_POST['idproveedor'];

		$query_delete = mysqli_query($laconexion,"UPDATE proveedor SET estatus = 0 WHERE idproveedor = $idproveedor ");
		mysqli_close($laconexion);
		if($query_delete){
			header("location: lista_proveedor.php");
		}else{
			echo "Error al eliminar";
		}

	}

 
	if(empty($_REQUEST['id']))
	{
		header("location: lista_proveedor.php");
		mysqli_close($laconexion);
	}else{

		$idproveedor = $_REQUEST['id'];

		$query = mysqli_query($laconexion,"SELECT idproveedor, proveedor, telefono, direccion FROM proveedor
												WHERE idproveedor= $idproveedor ");
		
		mysqli_close($laconexion);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				$proveedor = $data['proveedor'];
				$telefono     = $data['telefono'];
				$direccion = $data['direccion'];
			}
		}else{
			header("location: lista_proveedor.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente proveedor?</h2>
			<p>Proveedor: <span><?php echo $proveedor; ?></span></p>
			<p>Telefono: <span><?php echo $telefono; ?></span></p>
			<p>Dirección: <span><?php echo $direccion; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>">
				<a class="btn btn-danger" href="lista_proveedor.php" class="btn_cancel">Cancelar</a>
				<input class="btn btn-success" type="submit" value="Aceptar" >
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>