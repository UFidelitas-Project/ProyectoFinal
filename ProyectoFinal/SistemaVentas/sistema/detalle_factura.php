<?php 
	session_start();

	include "../conexion.php";



	if(empty($_REQUEST['id']) || $_REQUEST['id'] == 1 )
	{
		header("location: lista_venta.php");
		mysqli_close($conection);
	}else{

		$idFacrura = $_REQUEST['id'];

		$query = mysqli_query($laconexion,"SELECT nofactura,fecha,idcliente,totalfactura,usuario
												FROM factura
												WHERE nofactura = $idFacrura ");
		
		// mysqli_close($laconexion);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$idFactura = $data['nofactura'];
				$fecha = $data['fecha'];
				$monto = $data['totalfactura'];
				$idCliente = $data['idcliente'];

				$query2 = mysqli_query($laconexion,"SELECT nombre,cedula
														FROM cliente
														WHERE idcliente = $idCliente ");
				mysqli_close($laconexion);
				$result2 = mysqli_num_rows($query2);
				if($result2 > 0){
					while ($data2 = mysqli_fetch_array($query2)) {
						$cliente = $data2['nombre'];
						$cedula = $data2['cedula'];
					}
				}
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
			<h2>Detalles de la factura</h2>
			<p>Codigo: <span><?php echo $idFactura; ?></span></p>
			<p>Cliente: <span><?php echo $cliente; ?></span>-<span><?php echo $cedula; ?></span></p>
			<p>Fecha: <span><?php echo $fecha; ?></span></p>
			<p>Monto: <span><?php echo $monto; ?></span></p>

			<form method="post" action="">
				<a class="btn btn-success" href="lista_venta.php" class="btn_cancel">Volver</a>
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>