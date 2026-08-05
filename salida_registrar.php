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
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
                    require("modelo/m_mercaderia_salida.php");
                    require("modelo/m_cliente.php");

                    // Obtener todos los clientes registrados
                    $cliente = ListarClientes();

                    if(isset($_REQUEST['registrar']))
                    {
                        $id_cliente = $_REQUEST['id_cliente'];
                        $cantidad = $_REQUEST['cantidad'];
                        $producto = $_REQUEST['producto'];
                        $precio = $_REQUEST['precio'];
                        $fecha_registro = $_REQUEST['fecha_registro'];

                        // Registrar salida
                        $rpta = RegistrarSalida(
                            $id_cliente,
                            $cantidad,
                            $producto,
                            $precio,
                            $fecha_registro
                        );

                        if($rpta == "SI")
                        {
                            ?>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                            <script>
                            Swal.fire({
                                icon: 'success',
                                title: '¡Registro exitoso!',
                                text: 'La salida de mercadería fue registrada correctamente.',
                                confirmButtonText: 'Aceptar'
                            }).then((result) => {

                                if(result.isConfirmed)
                                {
                                    window.location = "salida_listar.php";
                                }

                            });
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