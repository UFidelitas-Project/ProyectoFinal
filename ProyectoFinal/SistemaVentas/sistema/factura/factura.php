<?php
	$total 		= 0;
 //print_r($configuracion); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

</head>
<body>
<?php echo $anulada; ?>
<div >
	<table>
		<tr>
			<td>
				<div>
					<img src="">
				</div>
			</td>
			<td>
				<div>
					<span><?php echo strtoupper($datos_empresa['nombre']); ?></span>
					<p><?php echo $datos_empresa['direccion']; ?></p>
					<p>Teléfono: <?php echo $datos_empresa['telefono']; ?></p>
					<p>Email: <?php echo $datos_empresa['email']; ?></p>
				</div>
				
			</td>
			<td>
				<div>
					<span >Factura</span>
					<p>No. Factura: <strong><?php echo $factura['nofactura']; ?></strong></p>
					<p>Fecha: <?php echo $factura['fecha']; ?></p>
					<p>Hora: <?php echo $factura['hora']; ?></p>
					<p>Vendedor: <?php echo $factura['vendedor']; ?></p>
				</div>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<div>
					<span>Cliente</span>
					<table>
						<tr>
							<td><label>Cedula:</label><p><?php echo $factura['cedula']; ?></p></td>
							<td><label>Teléfono:</label> <p><?php echo $factura['telefono']; ?></p></td>
						</tr>
						<tr>
							<td><label>Nombre:</label> <p><?php echo $factura['nombre']; ?></p></td>
							<td><label>Dirección:</label> <p><?php echo $factura['direccion']; ?></p></td>
						</tr>
					</table>
				</div>
			</td>

		</tr>
	</table>

	<table>
			<thead>
				<tr>
					<th width="50px">Cant.</th>
					<th>Descripción</th>
					<th width="150px">Precio Unitario.</th>
					<th width="150px"> Precio Total</th>
				</tr>
			</thead>
			<tbody id="detalle_productos">

			<?php

				if($result_detalle > 0){

					while ($row = mysqli_fetch_assoc($query_productos)){
			 ?>
				<tr>
					<td><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion']; ?></td>
					<td><?php echo $row['precio_venta']; ?></td>
					<td><?php echo $row['precio_total']; ?></td>
				</tr>
			<?php
						$precio_total = $row['precio_total'];
						$total = round($total + $precio_total, 2);
					}
				}

			?>
			</tbody>
			<tfoot>
				<tr>
					<td><span>TOTAL</span></td>
					<td><span><?php echo $total; ?></span></td>
				</tr>
		</tfoot>
	</table>
	<div>
		<p>Si usted tiene preguntas sobre esta factura, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4>¡Gracias por su compra!</h4>
	</div>

</div>

</body>
</html>