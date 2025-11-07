<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Registrar Venta</title>

    <?php require("vista/estilos.php"); ?>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<?php
// ✅ session_start seguro
if (!isset($_SESSION)) {
    session_start();
}

require("vista/menuh.php");
?>

<div id="layoutSidenav">

    <?php require("vista/menuv.php"); ?>

    <div id="layoutSidenav_content">
        <main>

            <?php
            require("modelo/m_venta.php");
            require("modelo/m_mediopago.php");

            $mediopago = ListarMediopagos();

            if (isset($_POST['registrar'])) {

                $cantidad = $_POST['cantidad'];
                $nom_producto = $_POST['nom_producto'];
                $precio_venta = $_POST['precio_venta'];
                $id_medio_pago = $_POST['id_medio_pago'];
                $id_usuario = $_SESSION['id_session'];

                $rpta = RegistrarVenta($cantidad, $nom_producto, $precio_venta, $id_medio_pago, $id_usuario);

                if ($rpta == "SI") {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Venta registrada correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.href = 'venta_listar.php';
                    });
                    </script>";
                }
            }

            require("vista/v_venta_registrar.php");
            ?>

        </main>

        <footer class="py-4 bg-light mt-auto">
            <?php require("vista/footer.php"); ?>   
        </footer>

    </div>

</div>

<?php require("vista/scripts.php"); ?>

</body>
</html>
