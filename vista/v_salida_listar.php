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
                            ?>
                            <tr>
                                <td><?= $n ?></td>
                                <td><?= $value['nombre'] ?></td>
                                <td><?= $value['cantidad'] ?></td>
                                <td><?= $value['producto'] ?></td>
                                <td><?= $value['precio'] ?></td>
                                <td><?= $value['fecha_registro'] ?></td>
                            </tr>
                        <?php 
                        }
                    ?>
                </tbody>
            </table>

            <!-- 🔹 TOTAL DE SALIDA DE MERCADERÍA -->
            <!--h3 class="text-end mt-3" id="totalFiltrado">
                Total: 
                <b style="color:blue;">S/
                    <?php  
                        $total_salida = 0;
                        foreach ($salida as $item) {
                            $total_salida += floatval($item['precio']);
                        }
                        echo number_format($total_salida, 2);
                    ?>
                </b>
            </h3-->
            <h3 class="text-end mt-3">
                Total: 
                <b style="color:blue;">
                    <span id="totalFiltrado">S/ 0.00</span>
                </b>
            </h3>

        </div>
    </div>
</div>

