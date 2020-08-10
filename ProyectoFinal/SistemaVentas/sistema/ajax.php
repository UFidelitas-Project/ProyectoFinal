<?php
    session_start();
    include "../conexion.php";	

    //Buscar cliente
    if($_POST['action'] == 'searchCliente'){

        if(!empty($_POST['cliente'])){
            $cedula = $_POST['cliente'];
            $query = mysqli_query($laconexion, "SELECT * FROM cliente WHERE cedula LIKE '$cedula' AND estatus = 1");
            mysqli_close($laconexion);
            $result = mysqli_num_rows($query);
    
            $data = '';
            if($result > 0){
                $data = mysqli_fetch_assoc($query);
            }else{
                $data = 0;
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
        }
        exit;

    }

    if($_POST['action'] == 'addCliente'){

        $cedula = $_POST['cedula_cliente'];
        $nombre = $_POST['nombre_cliente'];
        $telefono  = $_POST['telefono_cliente'];
        $direccion   = $_POST['direccion_cliente'];

        $query_insert = mysqli_query($laconexion, "INSERT INTO cliente(cedula,nombre,telefono,direccion)
                                            VALUES('$cedula','$nombre','$telefono','$direccion')");
        $data = '';
        if($query_insert){
            $data = mysqli_insert_id($laconexion);
        }else{
            $data = 'error';
        }
        mysqli_close($laconexion);
        echo $data;
        exit;
    }

    if($_POST['action'] == 'infoProducto'){

        if(!empty($_POST['producto'])){

            $producto = $_POST['producto'];

            $query = mysqli_query($laconexion, "SELECT idproducto,descripcion,existencia,precio FROM producto WHERE idproducto = '$producto' AND estatus = 1");
            mysqli_close($laconexion);
            $result = mysqli_num_rows($query);

            if($result > 0){
                $data = mysqli_fetch_assoc($query);
                echo json_encode($data, JSON_UNESCAPED_UNICODE);
            }else{
                echo 'error';
            }
            exit;
        }

    }

    if($_POST['action'] == 'addProductoDetalle'){

        if(!empty($_POST['producto']) && !empty($_POST['cantidad']) ){

            $producto = $_POST['producto'];
            $cantidad = $_POST['cantidad'];
            $token = md5($_SESSION['idUser']);

            $query = mysqli_query($laconexion, "CALL add_detalle_temp('$producto','$cantidad','$token')");
            $result = mysqli_num_rows($query);

            $detalleTabla = '';
            $total = 0;
            $arrayData = array();

            if($result > 0){

                while($data = mysqli_fetch_assoc($query)){
                    $preciototal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $total = round($total + $preciototal, 2);
    
                    $detalleTabla .= '<tr>
                                        <td>'.$data['idproducto'].'</td>
                                        <td colspan="2">'.$data['descripcion'].'</td>
                                        <td>'.$data['cantidad'].'</td>
                                        <td>'.$data['precio_venta'].'</td>
                                        <td>'.$preciototal.'</td>
                                        <td><a href="" class="btn btn-danger" onclick="event.preventDefault(); del_product_detalle('.$data['id_detemp'].');" >Eliminar</a></td>
                                    </tr>';
                }
    
                $detalleTotales = '<tr>
                                        <td colspan="2">TOTAL</td>
                                        <td>'.$total.'</td>
                                    </tr>';
                
                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;
    
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                
            }else{
                echo 'error';
            }
            mysqli_close($laconexion);
            
        }else{
            echo 'error';
        }
        exit;

    }

    if($_POST['action'] == 'searchForDetalle'){

        if(!empty($_POST['user'])){

            $token = md5($_POST['user']);

            $query = mysqli_query($laconexion, "SELECT tmp.id_detemp, tmp.idproducto, p.descripcion, p.idproducto, tmp.cantidad, tmp.precio_venta, tmp.token_user
                                                FROM detalle_temp tmp INNER JOIN producto p ON tmp.idproducto = p.idproducto 
                                                WHERE tmp.token_user = '$token'");
            $result = mysqli_num_rows($query);

            $detalleTabla = '';
            $total = 0;
            $arrayData = array();

            if($result > 0){

                while($data = mysqli_fetch_assoc($query)){
                    $preciototal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $total = round($total + $preciototal, 2);
    
                    $detalleTabla .= '<tr>
                                        <td>'.$data['idproducto'].'</td>
                                        <td colspan="2">'.$data['descripcion'].'</td>
                                        <td>'.$data['cantidad'].'</td>
                                        <td>'.$data['precio_venta'].'</td>
                                        <td>'.$preciototal.'</td>
                                        <td><a href="" class="btn btn-danger" onclick="event.preventDefault(); del_product_detalle('.$data['id_detemp'].');" >Eliminar</a></td>
                                    </tr>';
                }
    
                $detalleTotales = '<tr>
                                        <td colspan="2">TOTAL</td>
                                        <td>'.$total.'</td>
                                    </tr>';
                
                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;
    
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                
            }else{
                echo 'error';
            }
            mysqli_close($laconexion);
            
        }else{
            echo 'error';
        }
        exit;
    }

    if($_POST['action'] == 'delProductDetalle'){

        if(!empty($_POST['id_detalle'])){

            $id_detalle = $_POST['id_detalle'];
            $token = md5($_SESSION['idUser']);

            $query = mysqli_query($laconexion, "CALL del_detalle_temp('$id_detalle', '$token')");
            $result = mysqli_num_rows($query);

            $detalleTabla = '';
            $total = 0;
            $arrayData = array();

            if($result > 0){

                while($data = mysqli_fetch_assoc($query)){
                    $preciototal = round($data['cantidad'] * $data['precio_venta'], 2);
                    $total = round($total + $preciototal, 2);
    
                    $detalleTabla .= '<tr>
                                        <td>'.$data['idproducto'].'</td>
                                        <td colspan="2">'.$data['descripcion'].'</td>
                                        <td>'.$data['cantidad'].'</td>
                                        <td>'.$data['precio_venta'].'</td>
                                        <td>'.$preciototal.'</td>
                                        <td><a href="" onclick="event.preventDefault(); del_product_detalle('.$data['id_detemp'].');" >Eliminar</a></td>
                                    </tr>';
                }
    
                $detalleTotales = '<tr>
                                        <td colspan="2">TOTAL</td>
                                        <td>'.$total.'</td>
                                    </tr>';
                
                $arrayData['detalle'] = $detalleTabla;
                $arrayData['totales'] = $detalleTotales;
    
                echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
                
            }else{
                echo 'error';
            }
            mysqli_close($laconexion);
            
        }else{
            echo 'error';
        }
        exit;
    }

    if($_POST['action'] == 'anularVenta'){

        $token = md5($_SESSION['idUser']);

        $query = mysqli_query($laconexion, "DELETE FROM detalle_temp WHERE token_user = '$token'");
        mysqli_close($laconexion);

        if($query){
            echo 'ok';
        }else{
            echo 'error';
        }
        exit;

    }

    if($_POST['action'] == 'procesarVenta'){

        if(!empty($_POST['idcliente'])){

            $idcliente = $_POST['idcliente'];
            $token = md5($_SESSION['idUser']);
            $usuario = $_SESSION['idUser'];

            $query = mysqli_query($laconexion, "SELECT * FROM detalle_temp WHERE token_user = '$token'");
            $result = mysqli_num_rows($query);

            $detalleTabla = '';
            $total = 0;
            $arrayData = array();

            if($result > 0){

                $query_facturar = mysqli_query($laconexion, "CALL procesar_venta('$usuario','$idcliente','$token')");
                $result_facturar = mysqli_num_rows($query_facturar);

                if($result_facturar > 0){
                    $data = mysqli_fetch_assoc($query_facturar);
                    echo json_encode($data, JSON_UNESCAPED_UNICODE);
                }else{
                    echo 'error';
                }
                
            }else{
                echo 'error';
            }
            mysqli_close($laconexion);
            
        }else{
            echo 'error';
        }
        exit;
    }
 

?>