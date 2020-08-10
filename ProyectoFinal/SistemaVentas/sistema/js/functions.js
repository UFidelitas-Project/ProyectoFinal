$(document).ready(function() {
    
    //Activar los campos de registrar cliente
    $('.btn_new_cliente').click(function(e){
        e.preventDefault();
        $('#nombre_cliente').removeAttr('disabled');
        $('#telefono_cliente').removeAttr('disabled');
        $('#direccion_cliente').removeAttr('disabled');

        $('#div_registro_cliente').slideDown();
    });
    
    //Buscar cliente - completar campos cliente
    $('#cedula_cliente').keyup(function(e){
        e.preventDefault();
        var cliente= $(this).val();
        var action = 'searchCliente'

        $.ajax({
            url: 'ajax.php',
            type:  'POST',
            async: true,
            data: {action:action, cliente:cliente},
            success: function(response)
            {
                if(response == 0){
                    $('#idcliente').val('');
                    $('#nombre_cliente').val('');
                    $('#telefono_cliente').val('');
                    $('#direccion_cliente').val('');

                    $('.btn_new_cliente').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nombre_cliente').val(data.nombre);
                    $('#telefono_cliente').val(data.telefono);
                    $('#direccion_cliente').val(data.direccion);

                    $('.btn_new_cliente').slideUp();

                    $('#nombre_cliente').attr('disabled','disabled');
                    $('#telefono_cliente').attr('disabled','disabled');
                    $('#direccion_cliente').attr('disabled','disabled');

                    $('#div_registro_cliente').slideUp();
                }
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    //Crear cliente
    $('#form_new_cliente_venta').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: 'ajax.php',
            type:  'POST',
            async: true,
            data: $('#form_new_cliente_venta').serialize(),
            success: function(response)
            {
                if(response != 'error'){
                    $('#idcliente').val(response);
                    $('#nombre_cliente').attr('disabled','disabled');
                    $('#telefono_cliente').attr('disabled','disabled');
                    $('#direccion_cliente').attr('disabled','disabled');

                    $('.btn_new_cliente').slideUp();
                    $('#div_registro_cliente').slideUp();
                }
                
            },
            error: function(error){
                console.log(error);
            }
        });
    });

    //Buscar producto
    $('#txt_id_producto').keyup(function(e){
        e.preventDefault();
        var producto = $(this).val();
        var action = 'infoProducto';

        if(producto != ''){
            $.ajax({
                url: 'ajax.php',
                type:  'POST',
                async: true,
                data: {action:action, producto:producto},
                success: function(response)
                {
                    if(response != 'error'){
                        var info = JSON.parse(response);
                        $('#txt_descripcion').html(info.descripcion);
                        $('#txt_cant_producto').val('1');
                        $('#txt_existencia').html(info.existencia);
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio)

                        $('#txt_cant_producto').removeAttr('disabled');   
                        $('#add_product_venta').slideDown();
                    }else{
                        $('#txt_descripcion').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_existencia').html('-');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        $('#txt_cant_producto').attr('disabled','disabled');   
                        $('#add_product_venta').slideUp();
                    }
                    
                },
                error: function(error){
                    console.log(error);
                }
            });
        }

    });

    $('#txt_cant_producto').keyup(function (e){
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);
        

        if( ($(this).val() < 1 || isNaN($(this).val())) || ( $(this).val() > existencia ) ){
            $('#add_product_venta').slideUp();
        }else{
            $('#add_product_venta').slideDown();
        }

    });

    //Agregar productos al detalle temporal
    $('#add_product_venta').click(function(e){
        e.preventDefault();

        if($('#txt_cant_producto').val() > 0){

            var idproducto =  $('#txt_id_producto').val();
            var cantidad =  $('#txt_cant_producto').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: 'ajax.php',
                type:  'POST',
                async: true,
                data: {action:action, producto:idproducto, cantidad:cantidad},
                success: function(response)
                {
                    if(response != 'error'){
                        var info = JSON.parse(response);

                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales)

                        $('#txt_id_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_existencia').html('-');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        $('#txt_cant_producto').attr('disabled','disabled');  
                        $('#add_product_venta').slideUp();
                    }else{
                        console.log('error');
                    }
                    viewProcesar();
                },
                error: function(error){
                    console.log(error);
                }
            });
        }

    });

    //Anular venta
    $('#btn_anular_venta').click(function(e){
        e.preventDefault();

        var detalle = $('#detalle_venta tr').length;

        if(detalle > 0){

            var action = 'anularVenta';

            $.ajax({
                url: 'ajax.php',
                type:  'POST',
                async: true,
                data: {action:action},
                success: function(response)
                {
                    if(response != 'error'){
                        location.reload();
                    }else{
                        console.log('error');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }

    });

     //Facturar venta
     $('#btn_facturar_venta').click(function(e){
        e.preventDefault();

        var detalle = $('#detalle_venta tr').length;

        if(detalle > 0){

            var action = 'procesarVenta';
            var idcliente = $('#idcliente').val();

            $.ajax({
                url: 'ajax.php',
                type:  'POST',
                async: true,
                data: {action:action, idcliente:idcliente},
                success: function(response)
                {
                    if(response != 'error'){
                        var info = JSON.parse(response);
                        generarPDF(info.idcliente,info.nofactura);

                        location.reload();
                    }else{
                        console.log('No hay datos');
                    }
                },
                error: function(error){
                    console.log(error);
                }
            });
        }

    });


});

//Agregar productos al detalle cuando se recarga la pagina
function seachForDetalle(id){
    var action = 'searchForDetalle';
    var user = id;

    $.ajax({
        url: 'ajax.php',
        type:  'POST',
        async: true,
        data: {action:action, user:user},
        success: function(response)
        {
            if(response != 'error'){
                var info = JSON.parse(response);

                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales)
            }
            viewProcesar();
        },
        error: function(error){
            console.log(error);
        }
    });
}

//Eliminar producto del detalle
function del_product_detalle(id_detemp){
    var action = 'delProductDetalle';
    var id_detalle = id_detemp;

    $.ajax({
        url: 'ajax.php',
        type:  'POST',
        async: true,
        data: {action:action, id_detalle:id_detalle},
        success: function(response)
        {
            if(response != 'error'){
                var info = JSON.parse(response);

                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

                $('#txt_descripcion').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_existencia').html('-');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                $('#txt_cant_producto').attr('disabled','disabled');  
                $('#add_product_venta').slideUp();
            }else{
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            }
            viewProcesar();
        },
        error: function(error){
            console.log(error);
        }
    });
}

function viewProcesar(){
    if($('#detalle_venta tr').length > 0){
        $('#btn_facturar_venta').show();
    }else{
        $('#btn_facturar_venta').hide();
    }
}

function generarPDF(cliente,factura){
    var ancho = 1000;
    var alto = 800;

    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (ancho / 2));

    $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
    window.open($url,"Factura","left="+x+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}
