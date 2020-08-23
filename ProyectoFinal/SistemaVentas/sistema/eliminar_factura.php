<?php 
	session_start();

	include "../conexion.php";

	if(!empty($_POST))
	{
		if($_POST['nofactura'] == 1){
			header("location: lista_usuario.php");
			mysqli_close($conection);
			exit;
		}
		$idFactura = $_POST['nofactura'];

		$query_delete = mysqli_query($laconexion,"UPDATE factura SET estatus = 0 WHERE nofactura = $idFactura ");
		mysqli_close($conection);
		if($query_delete){
			header("location: lista_venta.php");
		}else{
			echo "Error al eliminar";
		}

	}




	if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1 )
	{
		header("location: lista_venta.php");
		mysqli_close($conection);
	}else{

		$idusuario = $_REQUEST['id'];

		$query = mysqli_query($laconexion,"SELECT nofactura,fecha,totalfactura
												FROM factura
												WHERE nofactura = $idusuario ");
		
		mysqli_close($laconexion);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$idFactura = $data['nofactura'];
				$fecha = $data['fecha'];
				$monto = $data['totalfactura'];
			}
		}else{
			header("location: lista_venta.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Factura</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente registro?</h2>
			<p>Codigo: <span><?php echo $idFactura; ?></span></p>
			<p>Fecha: <span><?php echo $fecha; ?></span></p>
			<p>Monto: <span><?php echo $monto; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="nofactura" value="<?php echo $idFactura; ?>">
				<a class="btn btn-danger" href="lista_venta.php" class="btn_cancel">Cancelar</a>
				<input class="btn btn-success" type="submit" value="Aceptar">
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>