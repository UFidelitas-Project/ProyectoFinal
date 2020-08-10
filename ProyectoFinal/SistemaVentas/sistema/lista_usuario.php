<?php 
	session_start();
	include "../conexion.php";	

 ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de usuarios</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<h1>Lista de usuarios</h1>
		<a class="btn btn-success crear" href="registro_usuario.php">Crear usuario</a>

		<table>
			<tr>
				<th>ID</th>
				<th>Nombre</th>
				<th>Correo</th>
				<th>Usuario</th>
				<th>Acciones</th>
			</tr>
		<?php 
			$query = mysqli_query($laconexion,"SELECT idusuario,nombre,correo,usuario FROM usuario WHERE estatus = 1 ORDER BY idusuario ASC ");

			mysqli_close($laconexion);

			$result = mysqli_num_rows($query);
			if($result > 0){

				while ($data = mysqli_fetch_array($query)) {
					
			?>
				<tr>
					<td><?php echo $data["idusuario"]; ?></td>
					<td><?php echo $data["nombre"]; ?></td>
					<td><?php echo $data["correo"]; ?></td>
					<td><?php echo $data["usuario"]; ?></td>
					<td>
						<a class="link_edit btn btn-primary" href="editar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Editar</a>

					<?php if($data["idusuario"] != 1){ ?>
						<a class="link_delete btn btn-danger" href="eliminar_usuario.php?id=<?php echo $data["idusuario"]; ?>">Eliminar</a>
					<?php } ?>
						
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