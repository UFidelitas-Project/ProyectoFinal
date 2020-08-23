<?php 
	session_start();
	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de ventas</h1>

		<table>
			<tr>
				<th>ID</th>
				<th>Fecha</th>
				<th>Cliente</th>
                <th>Monto</th>
                <th>Usuario</th>
				<th>Acciones</th>
			</tr>
		<?php 
			
			$query = mysqli_query($laconexion,"SELECT nofactura, fecha, idcliente, totalfactura, usuario 
            FROM factura 
            WHERE estatus = 1 
            ORDER BY fecha ASC");

			mysqli_close($laconexion);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["nofactura"]; ?></td>
					<td><?php echo $data["fecha"]; ?></td>
					<td><?php echo $data["idcliente"]; ?></td>
					<td><?php echo $data["totalfactura"]; ?></td>
					<td><?php echo $data["usuario"]; ?></td>
					<td>
						<a class="btn btn-danger" href="eliminar_factura.php?id=<?php echo $data["nofactura"]; ?>">Eliminar</a>
						<a class="btn btn-danger" href="detalle_factura.php?id=<?php echo $data["nofactura"]; ?>">Detalles</a>	
						<a class="btn btn-danger" href="factura/generaFactura.php
                            ?cl=<?php echo $data["idcliente"]; ?>
                            &f=<?php echo $data["nofactura"]; ?>"
                            >Reimprimir
                        </a>	
					</td>
				</tr>
			
		<?php 
				} 

			}
		 ?>


		</table>

	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>