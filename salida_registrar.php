<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registrar Salida de mercaderia de la tienda</title>
        <?php
         require("vista/estilos.php");
        ?>
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                    require("modelo/m_mercaderia_salida.php");
                     if(isset($_REQUEST['registrar']))
                    {
                        $nombre = $_REQUEST['nombre'];
                        $cantidad = $_REQUEST['cantidad'];
                        $producto = $_REQUEST['producto'];
                        $precio = $_REQUEST['precio'];
                        $fecha_registro = $_REQUEST['fecha_registro'];
                        
                        
                        $rpta = RegistrarSalida($nombre,$cantidad,$producto,$precio,$fecha_registro);

                        if($rpta=="SI")
                        {
                            ?>
                            <script type="text/javascript">
                                location.href="salida_listar.php";
                            </script>
                            <?php
                        }

                    }

                    require("vista/v_salida_registrar.php");
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
