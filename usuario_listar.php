<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Lista de Ventas</title>
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
                    require("modelo/m_usuario.php");


                    
                    //Si se presiona el boton editar
                    if(isset($_REQUEST['editar']))
                    {
                        $id_usuario = $_REQUEST['editar'];
                        ?>
                            <script type="text/javascript">
                                location.href="usuario_editar.php?id_usuario=<?php echo $id_usuario; ?>";
                            </script>
                        
                        <?php
                    }
                    //Si se presiona el boton eliminar
                    else if(isset($_REQUEST['eliminar']))
                    {
                        
                        $id_usuario = $_REQUEST['eliminar'];
                        $rpta = EliminarUsuario($id_usuario);
                        if($rpta=="SI")
                        {
                            ?>
                                <script type="text/javascript">
                                    alert("Eliminado correctamente!");
                                </script>
                            <?php
                        }

                    }    

                    $usuario = ListarUsuarios();
                    require("vista/v_usuario_listar.php");
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
