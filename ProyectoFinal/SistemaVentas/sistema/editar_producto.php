<?php 
	session_start();
	include "../conexion.php"; 

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['idproducto']) || empty($_POST['precio'])|| empty($_POST['existencia'])||empty($_POST['idproducto']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{
           
            $idproducto= $_POST['idproducto'];
			$precio= $_POST['precio'];
            $descripcion  = $_POST['descripcion'];
            $existencia  = $_POST['existencia'];
            
            
            

			$sql_update = mysqli_query($laconexion,"UPDATE producto
													SET descripcion='$descripcion',precio='$precio',existencia='$existencia'
											     	WHERE idproducto= '$idproducto' ");
		
			if($sql_update){
				$alert='<p class="msg_save">Producto actualizado correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al actualizar el producto.</p>';
			}

		}

	}


	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_producto.php');
		mysqli_close($laconexion);
	}
	$idproducto = $_REQUEST['id'];

	$sql= mysqli_query($laconexion,"SELECT idproducto, descripcion, precio,existencia FROM producto WHERE idproducto = '$idproducto' ");
	mysqli_close($laconexion);
	$result_sql = mysqli_num_rows($sql);

	if($result_sql == 0){
		header('Location: lista_producto.php');
	}else{
		$option = '';
		while ($data = mysqli_fetch_array($sql)) {
			
			$idproducto = $data['idproducto'];
			$descripcion = $data['descripcion'];
            $precio = $data['precio'];
            $existencia = $data['existencia'];
			
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<div class="col-md-6">
				<h1>Actualizar producto</h1>
				<hr>
				<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
			</div>
			<form action="" method="post">
				<div class="form-group col-md-6">
					<label for="descripcion">Producto</label>
					<input class="form-control" type="text" name="descripcion" id="descripcion" placeholder="producto" value="<?php echo $descripcion; ?>">
				</div>
				
				<div class="form-group col-md-6">
					<label for="precio">Precio</label>
					<input class="form-control" type="text" name="precio" id="precio" placeholder="Precio" value="<?php echo $precio; ?>">
                </div>
                <div class="form-group col-md-6">
					<label for="existencia">Existencia</label>
					<input class="form-control" type="text" name="existencia" id="existencia" placeholder="Existencia" value="<?php echo $existencia; ?>">
				</div>
				<div class="form-group col-md-6">
					<input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
					<input class="btn btn-primary btn_save" type="submit" value="Actualizar producto">
				</div>
			</form>

		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>