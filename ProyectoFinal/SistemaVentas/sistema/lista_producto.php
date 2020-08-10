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
		
		<h1>Lista de productos</h1>
		<a class="btn btn-success crear" href="registro_producto.php">Agregar producto</a>

		<table>
			<tr>
				<th>ID</th>
				<th>Producto</th>
				<th>Proveedor</th>
                <th>Existencia</th>
                <th>Precio</th>
				<th>Acciones</th>
			</tr>
		<?php 
			
			$query = mysqli_query($laconexion,"SELECT idproducto, descripcion, proveedor, existencia, precio FROM producto WHERE estatus = 1 ORDER BY idproducto ASC");

			mysqli_close($laconexion);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idproducto"]; ?></td>
					<td><?php echo $data["descripcion"]; ?></td>
					<td><?php echo $data["proveedor"]; ?></td>
					<td><?php echo $data["existencia"]; ?></td>
					<td><?php echo $data["precio"]; ?></td>
					<td>
						<a class="btn btn-primary" href="editar_producto.php?id=<?php echo $data["idproducto"]; ?>">Editar</a>
						<a class="btn btn-danger" href="eliminar_producto.php?id=<?php echo $data["idproducto"]; ?>">Eliminar</a>
						
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