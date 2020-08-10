<?php 
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['proveedor']) || empty($_POST['descripcion']) || empty($_POST['precio']) || empty($_POST['cantidad']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$proveedor = $_POST['proveedor'];
			$descripcion = $_POST['descripcion'];
			$precio = $_POST['precio'];
			$cantidad = $_POST['cantidad'];

			$query = mysqli_query($laconexion,"SELECT * FROM producto WHERE lower(descripcion) = lower('$descripcion') ");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El producto ya existe.</p>';
			}else{

				$query_insert = mysqli_query($laconexion,"INSERT INTO producto(descripcion,proveedor,precio,existencia)
																	VALUES('$descripcion','$proveedor','$precio','$cantidad')");
				if($query_insert){
					$alert='<p class="msg_save">Producto agregado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al agregar el producto.</p>';
				}

			}


		}

	}



 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<div class="col-md-6">
				<h1>Registro Producto</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group col-md-3">
					<label for="proveedor">Proveedor</label>
					<?php 
						$query_proveedor = mysqli_query($laconexion,"SELECT idproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
						$result_proveedor = mysqli_num_rows($query_proveedor);
						mysqli_close($laconexion);
					?>

					<select class="form-control" name="proveedor" id="proveedor">
						<?php 
							if($result_proveedor > 0)
							{
								while ($proveedor = mysqli_fetch_array($query_proveedor)) {
						?>
								<option value="<?php echo $proveedor["idproveedor"]; ?>"><?php echo $proveedor["proveedor"] ?></option>
						<?php 
								}							
							}
						?>
					</select>
				</div>
				<div class="form-group col-md-6">
					<label for="descripcion">Producto</label>
					<input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="Descripción">
				</div>
				<div class="form-group col-md-6">
					<label for="precio">Precio</label>
					<input class="form-control" type="number" name="precio" id="precio" placeholder="Precio">
				</div>
				<div class="form-group col-md-6">
					<label for="cantidad">Cantidad</label>
					<input class="form-control" type="number" name="cantidad" id="cantidad" placeholder="Cantidad">
				</div>
				<div class="form-group col-md-6">
					<input type="submit" value="Agregar producto" class="btn btn-primary btn_save">
				</div>
			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>