<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edición de Venta</title>
         <?php
         require("vista/estilos.php");
        ?>
    </head>
    <body class="sb-nav-fixed">
        
        <?php
         require("vista/menuh.php");
        ?>

        <div id="layoutSidenav">
          
            <?php
            require("vista/menuv.php");
            ?>

            <div id="layoutSidenav_content">
                <main>
                    <?php 
                    require("modelo/m_venta.php");
                    require("modelo/m_mediopago.php");
                    //Si se presiona el boton actualizar
                    if(isset($_REQUEST['actualizar']))
                    {
                        $id_venta = $_REQUEST['id_venta'];
                        $cantidad = $_REQUEST['cantidad'];
                        $nom_producto = $_REQUEST['nom_producto'];
                        $precio_venta = $_REQUEST['precio_venta'];
                        $precio_efectivo = $_REQUEST['precio_efectivo'];
                        $precio_yape = $_REQUEST['precio_yape'];
                        $id_medio_pago = $_REQUEST['id_medio_pago'];

                        // 🔥 PRIMERO calculamos el total real
                        $total = $precio_efectivo + $precio_yape;

                        // 🔥 AHORA movemos el dinero según el nuevo método
                        if ($id_medio_pago == 6) {  // Yape
                            $precio_yape = $total;
                            $precio_efectivo = 0;
                        }

                        if ($id_medio_pago == 7) {  // Efectivo
                            $precio_efectivo = $total;
                            $precio_yape = 0;
                        }

                        // 🔥 RECIÉN AQUÍ actualizamos
                        $rpta = ActualizarVenta(
                            $id_venta,
                            $cantidad,
                            $nom_producto,
                            $precio_venta,
                            $precio_efectivo,
                            $precio_yape,
                            $id_medio_pago
                        );

                        if($rpta=="SI")
                        {
                            ?>
                            <script type="text/javascript">
                                alert("Se actualizó correctamente");
                                location.href="venta_listar.php";
                            </script>
                            <?php
                        }
                    }

                    $id_venta =  $_REQUEST['id_venta'];

                    $venta = ConsultarVenta($id_venta);
                    foreach ($venta as $key => $value) 
                    {

                        $cantidad = $value['cantidad'];
                        $nom_producto = $value['nom_producto'];
                        $precio_venta = $value['precio_venta'];
                        $precio_efectivo = $value['precio_efectivo'];
                        $precio_yape = $value['precio_yape'];
                        $id_medio_pago = $value['id_medio_pago'];
                    }
                    $total = $precio_efectivo + $precio_yape;


                    $mediopago = ListarMediopagos();
                    require("vista/v_venta_editar.php");
                    ?>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <?php
                    require("vista/footer.php");
                    ?>   
                </footer>
            </div>
        </div>
        <?php
        require("vista/scripts.php");
        ?>  
    </body>
</html>
