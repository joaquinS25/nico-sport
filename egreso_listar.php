<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Lista de Egresos</title>
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
                    require("modelo/m_egreso.php");


                    //Si se presiona el boton editar
                    if(isset($_REQUEST['editar']))
                    {
                        $id_egreso = $_REQUEST['editar'];
                        ?>
                            <script type="text/javascript">
                                location.href="egreso_editar.php?id_egreso=<?php echo $id_egreso; ?>";
                            </script>
                        
                        <?php
                    }

                    $egresos = ListarEgresos();


                    
                    $fecha = $_GET['fecha'] ?? date('Y-m-d');

                    $egresos = ListarEgresosPorFecha($fecha);
                    require("vista/v_egreso_listar.php");
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
