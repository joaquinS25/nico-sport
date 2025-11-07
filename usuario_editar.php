<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Edición de Usuario</title>
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
                    require("modelo/m_usuario.php");

                    //Si se presiona el boton actualizar
                    if(isset($_REQUEST['actualizar']))
                    {
                        $id_usuario = $_REQUEST['actualizar'];
                        $nom_usuario = $_REQUEST['nom_usuario'];
                        $ape_usuario = $_REQUEST['ape_usuario'];
                        $email_usuario = $_REQUEST['email_usuario'];
                        $user_usuario = $_REQUEST['user_usuario'];
                        $pass_usuario = $_REQUEST['pass_usuario'];

                        $rpta = ActualizarUsuario($id_usuario,$nom_usuario,$ape_usuario,$email_usuario,$user_usuario,$pass_usuario);

                        if($rpta=="SI")
                        {
                            ?>
                            <script type="text/javascript">
                                alert("Se actualizó correctamente");
                                location.href="usuario_listar.php";
                            </script>
                            <?php
                        }

                    }

                    $id_usuario =  $_REQUEST['id_usuario'];

                    $usuario = ConsultarUsuario($id_usuario);
                    foreach ($usuario as $key => $value) 
                    {
                        $nom_usuario = $value['nom_usuario'];
                        $ape_usuario = $value['ape_usuario'];
                        $email_usuario = $value['email_usuario'];
                        $user_usuario = $value['user_usuario'];
                        $pass_usuario = $value['pass_usuario'];
                    }

                    require("vista/v_usuario_editar.php");
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
