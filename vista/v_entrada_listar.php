<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Entrada de Mercaderia</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Entrada de Mercaderia
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cantidad</th>
                        <th>Porducto</th>
                        <th>Precio</th>
                        <th>Proveedor</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Cantidad</th>
                        <th>Porducto</th>
                        <th>Precio</th>
                        <th>Proveedor</th>
                        <th>Fecha Registro</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($entrada as $key => $value) 
                        {
                            $n++;
                            $id_entrada = $value['id_entrada'];
                            $cantidad = $value['cantidad'];
                            $producto = $value['producto'];
                            $precio = $value['precio'];
                            $proveedor = $value['proveedor'];
                            $fecha_registro = $value['fecha_registro'];
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $cantidad; ?></td>
                                <td><?php echo $producto; ?></td>
                                <td><?php echo $precio; ?></td>
                                <td><?php echo $proveedor; ?></td>
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