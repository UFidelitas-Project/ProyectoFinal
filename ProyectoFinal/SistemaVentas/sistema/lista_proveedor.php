<?php 
	session_start();
	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de proveedores</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de proveedores</h1>
		<a class="btn btn-success crear" href="registro_proveedor.php" class="btn_new">Crear proveedor</a>

		<table>
			<tr>
				<th>ID</th>
				<th>Proveedor</th>
				<th>Telefono</th>
				<th>Dirección</th>
				<th>Acciones</th>
			</tr>
		<?php 
			$query = mysqli_query($laconexion,"SELECT idproveedor, proveedor, telefono, direccion FROM proveedor WHERE estatus = 1 ORDER BY idproveedor ASC");

			mysqli_close($laconexion);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idproveedor"]; ?></td>
					<td><?php echo $data["proveedor"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td>
						<a class="btn btn-primary" class="link_edit" href="editar_proveedor.php?id=<?php echo $data["idproveedor"]; ?>">Editar</a>
						<a class="btn btn-danger" class="link_delete" href="eliminar_proveedor.php?id=<?php echo $data["idproveedor"]; ?>">Eliminar</a>
						
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