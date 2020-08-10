<?php 
	session_start();
	include "../conexion.php";	 

 ?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sistema Ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

        <div class="datos_cliente">
        <h1>Nueva venta</h1>
        <br>
        <br>
            <div>
                <h4>Datos cliente</h4>
                <a href="" class="btn btn-info btn_new_cliente">Nuevo Cliente</a>
            </div>
            <form name="form_new_cliente_venta" id="form_new_cliente_venta">
                <input type="hidden" name="action" value="addCliente">
                <input type="hidden" id="idcliente" name="idcliente" value="" required>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cedula">Cedula</label>
                        <input class="form-control" type="number" name="cedula_cliente" id="cedula_cliente" placeholder="Cedula">
                    </div>
                    <div class="form-group col-md-5">
                        <label for="nombre">Nombre</label>
                        <input class="form-control" type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre completo" disabled required>
                    </div>
                </div>
                <div class="form-row">   
                    <div class="form-group col-md-4">            
                        <label for="telefono">Telefono</label>
                        <input class="form-control" type="number" name="telefono_cliente" id="telefono_cliente" placeholder="Telefono" disabled required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="direccion">Dirección</label>
                        <input class="form-control" type="text" name="direccion_cliente" id="direccion_cliente" placeholder="Dirección" disabled required>
                    </div>
                </div>
                <div id="div_registro_cliente">
                    <button class="btn btn-info" type="submit">Guardar</button>
                </div>
            </form>
        </div>
        <div class="datos_venta">
            <div class="form-row">
                <div class="form-group">
                    <h4>Datos de Venta</h4>
                    <h5>Vendedor:</h5>
                    <p><?php echo $_SESSION['nombre'] ?></p>
                </div>
                <div class="form-group acciones">
                    <h4>Acciones</h4>
                    <div class="form-inline">
                        <a href="" class="btn btn-danger" id="btn_anular_venta">Anular</a>
                        <a href="" class="btn btn-success" id="btn_facturar_venta" >Procesar</a>
                    </div>
                </div>
            </div>
        </div>

        <table class="tbl_venta">
            <thead>
                <tr>
                    <th width="100px">ID</th>
                    <th>Descripción</th>
                    <th>Existencia</th>
                    <th width="100px">Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th>Accion</th>
                </tr>
                <tr>
                    <td><input type="text" name="txt_id_producto" id="txt_id_producto"></td>
                    <td id="txt_descripcion">-</td>
                    <td id="txt_existencia">-</td>
                    <td><input type="text" name="txt_cant_producto" id="txt_cant_producto" value="0" min="1" disabled></td>
                    <td id="txt_precio">0.00</td>
                    <td id="txt_precio_total">0.00</td>
                    <td><a href="" class="btn btn-info" id="add_product_venta">Agregar</a></td>
                </tr>
                <tr>
                    <th>ID</th>
                    <th colspan="2">Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody id="detalle_venta">
                
            </tbody>
            <tfoot id='detalle_totales'>
                
            </tfoot>
        </table>
    
    </section>
	<?php include "includes/footer.php" ?>

    <script type="text/javascript">
        $(document).ready(function(){
            var idusuario = '<?php echo $_SESSION['idUser']; ?>';
            seachForDetalle(idusuario);
        });
    </script>

</body>
</html>