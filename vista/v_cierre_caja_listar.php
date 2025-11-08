<div class="container-fluid px-4">
    <h1 class="mt-4">Cierre de Caja</h1>
    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
        <!-- Selector de fecha >
        <input type="date" id="fechaCierre" class="form-control w-auto" value="<?php echo date('Y-m-d'); ?>">

        < Botón cerrar caja >
        <button id="btnCerrarCaja" class="btn btn-danger">
            <i class="fas fa-lock"></i> Cerrar Caja
        </button-->
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Cierre de Caa
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Cierre</th>
                        <th>Total Ventas</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Cierre</th>
                        <th>Total Ventas</th>
                        <th>Usuario</th>
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
                                <td><?php echo $value['id_cierre']; ?></td>
                                <td><?php echo $value['fecha_cierre']; ?></td>
                                <td><?php echo $value['total_ventas']; ?></td>
                                <td><?php echo $value['nom_usuario']." ".$value['ape_usuario']; ?></td>
                            </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
