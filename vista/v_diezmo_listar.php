<div class="container-fluid px-4">
    <h1 class="mt-4">Diezmo</h1>
   

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Listar Diezmo
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Monto Diezmo</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Monto Diezmo</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $n=0;
                        foreach ($ventas as $value) {
                            $n++;
                            ?>
                            <tr>
                                <td><?php echo $n; ?></td>
                                <td><?php echo $value['id_diezmo']; ?></td>
                                <td><?php echo $value['fecha_inicio']; ?></td>
                                <td><?php echo $value['fecha_fin']; ?></td>
                                <td><?php echo $value['monto_diezmo']; ?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
