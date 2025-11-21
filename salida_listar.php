<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Lista de mercaderia que sale de la tienda</title>
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

                    $salida = ListarSalida();
                    require("vista/v_salida_listar.php");
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
