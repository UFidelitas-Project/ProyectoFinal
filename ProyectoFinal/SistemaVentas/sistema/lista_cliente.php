<?php 
	session_start();
	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de clientes</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de clientes</h1>
		<a class="btn btn-success crear" href="registro_cliente.php">Crear cliente</a>

		<table>
			<tr>
				<th>ID</th>
				<th>Cedula</th>
				<th>Nombre</th>
				<th>Telefono</th>
				<th>Dirección</th>
				<th>Acciones</th>
			</tr>
		<?php 

			$query = mysqli_query($laconexion,"SELECT idcliente, cedula, nombre, telefono, direccion FROM cliente WHERE estatus = 1 ORDER BY idcliente ASC");

			mysqli_close($laconexion);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idcliente"]; ?></td>
					<td><?php echo $data["cedula"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["telefono"]; ?></td>
					<td><?php echo $data["direccion"]; ?></td>
					<td>
						<a class="btn btn-primary" href="editar_cliente.php?id=<?php echo $data["idcliente"]; ?>">Editar</a>
						<a class="btn btn-danger" href="eliminar_cliente.php?id=<?php echo $data["idcliente"]; ?>">Eliminar</a>
						
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