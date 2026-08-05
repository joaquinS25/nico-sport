<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Registrar Cliente</title>

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
            require("modelo/m_cliente.php");
            $cliente = ListarClientes();

            if (isset($_POST['registrar'])) {

                $nom_cliente = $_POST['nom_cliente'];
                $cel_cliente = $_POST['cel_cliente'];
                $tienda_cliente = $_POST['tienda_cliente'];

                $rpta = RegistrarCliente($nom_cliente, $cel_cliente, $tienda_cliente);

                if ($rpta == "SI") {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Cliente registrado correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.href = 'cliente_listar.php';
                    });
                    </script>";
                }else {

                echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo registrar el cliente.',
                    confirmButtonText: 'Aceptar'
                });
                </script>";
            }
            }

            require("vista/v_cliente_registrar.php");
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
