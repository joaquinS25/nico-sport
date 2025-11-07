<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Ventas</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Ventas
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Venta</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Medio de Pago</th>
                        <th>Usuario</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Venta</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Medio de Pago</th>
                        <th>Usuario</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($ventas as $key => $value) 
                        {
                            $n++;
                            $id_venta = $value['id_venta'];
                            $fecha_venta = $value['fecha_venta'];
                            $cantidad = $value['cantidad'];
                            $nom_producto = $value['nom_producto'];
                            $precio_venta = $value['precio_venta'];
                            $medio_pago = $value['nom_medio_pago'];
                            $nom_usuario = $value['nom_usuario'];
                            $ape_usuario = $value['ape_usuario'];
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $id_venta; ?></td>
                                <td><?php echo $fecha_venta; ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $nom_producto; ?></td>
                                <td><?php echo $precio_venta; ?></td>
                                <td><?php echo $medio_pago; ?></td>
                                <td><?php echo $nom_usuario." ".$ape_usuario; ?></td>
                                
                    
                            </tr>
                            


                        <?php 
                        }
                        ?>

                </tbody>
            </table>
        </div>
    </div>
</div>