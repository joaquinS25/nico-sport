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
            require("modelo/m_usuario.php");

            $usaurio = ListarUsuarios();

            if (isset($_POST['registrar'])) {

                $nom_usuario = $_POST['nom_usuario'];
                $ape_usuario = $_POST['ape_usuario'];
                $email_usuario = $_POST['email_usuario'];
                $user_usuario = $_POST['user_usuario'];
                $pass_usuario = $_POST['pass_usuario'];

                $rpta = RegistrarUsuario($nom_usuario, $ape_usuario, $email_usuario, $user_usuario, $pass_usuario);

                if ($rpta == "SI") {
                    echo "
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario registrado correctamente',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        location.href = 'usuario_listar.php';
                    });
                    </script>";
                }
            }

            require("vista/v_usuario_registrar.php");
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
