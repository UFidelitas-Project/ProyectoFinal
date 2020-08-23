<?php 
	session_start();
	include "../conexion.php";

	if(!empty($_POST))
	{
		$idproducto = $_POST['idproducto'];

		$query_delete = mysqli_query($laconexion,"UPDATE producto SET estatus = 0 WHERE idproducto = $idproducto ");
		mysqli_close($laconexion);
		if($query_delete){
			header("location: lista_producto.php");
		}else{
			echo "Error al eliminar";
		}

	}

 
	if(empty($_REQUEST['id']))
	{
		header("location: lista_producto.php");
		mysqli_close($laconexion);
	}else{

		$idproducto = $_REQUEST['id'];

		$query = mysqli_query($laconexion,"SELECT idproducto, precio, descripcion, existencia,proveedor FROM producto
												WHERE idproducto= $idproducto ");
		
		mysqli_close($laconexion);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				$proveedor = $data['proveedor'];
				$existencia = $data['existencia'];
				$descripcion = $data['descripcion'];
				$precio = $data['precio'];
			}
		}else{
			header("location: lista_producto.php");
		}


	}


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<h2>¿Está seguro de eliminar el siguiente producto?</h2>
			<p>Producto: <span><?php echo $descripcion; ?></span></p>
			<p>Precio: <span><?php echo $precio; ?></span></p>
			<p>Existencia: <span><?php echo $existencia; ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idproducto" value="<?php echo $idproducto; ?>">
				<a class="btn btn-danger" href="lista_producto.php" class="btn_cancel">Cancelar</a>
				<input class="btn btn-success" type="submit" value="Aceptar" >
			</form>
		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>