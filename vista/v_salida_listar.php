<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Salida de Mercaderia de la tienda</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Salida de Mercaderia
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Fecha Registro</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($salida as $key => $value) 
                        {
                            $n++;
                            $id_salida = $value['id_salida'];
                            $nombre = $value['nombre'];
                            $cantidad = $value['cantidad'];
                            $producto = $value['producto'];
                            $precio = $value['precio'];
                            $fecha_registro = $value['fecha_registro'];
                            
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $nombre; ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $producto; ?></td>
                                <td><?php echo $precio; ?></td>
                                <td><?php echo $fecha_registro; ?></td>
                            </tr>
                            


                        <?php 
                        }
                        ?>

                </tbody>
            </table>
        </div>
    </div>
</div>