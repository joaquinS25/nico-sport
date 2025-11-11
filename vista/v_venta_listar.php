<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Ventas</h1>
    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
        <input type="date" id="fechaCierre" class="form-control w-auto" value="<?php echo date('Y-m-d'); ?>">
        <button id="btnCerrarCaja" class="btn btn-danger">
            <i class="fas fa-lock"></i> Cerrar Caja
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="fas fa-table me-1"></i> Ventas</div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha Venta</th>
                        <th>Cantidad</th>
                        <th>Producto</th>
                        <th>Precio Total</th>
                        <th>Efectivo</th>
                        <th>Yape</th>
                        <th>Medio de Pago</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $n=0;
                    foreach ($ventas as $value) {
                        $n++;
                    ?>
                    <tr>
                        <td><?= $n ?></td>
                        <td><?= $value['id_venta'] ?></td>
                        <td><?= $value['fecha_venta'] ?></td>
                        <td><?= $value['cantidad'] ?></td>
                        <td><?= $value['nom_producto'] ?></td>
                        <td><?= $value['precio_venta'] ?></td>
                        <td><?= $value['precio_efectivo'] ?></td>
                        <td><?= $value['precio_yape'] ?></td>
                        <td><?= $value['nom_medio_pago'] ?></td>
                        <td><?= $value['nom_usuario']." ".$value['ape_usuario'] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnCerrarCaja').addEventListener('click', function() {
    const fecha = document.getElementById('fechaCierre').value;

    if (!fecha) {
        Swal.fire('Error', 'Selecciona una fecha de cierre', 'error');
        return;
    }

    Swal.fire({
        title: '¿Cerrar caja?',
        text: 'Se calcularán los montos de Yape, Efectivo y Total del día ' + fecha,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cerrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('cerrar_caja.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'fecha=' + fecha
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Caja cerrada',
                        html: `
                            <b>Fecha:</b> ${data.fecha}<br>
                            <b>Total ventas:</b> S/ ${data.total_yape}<br>
                            <b>Total Efectivo:</b> S/ ${data.total_efectivo}<br>
                            <b>Total Ventas:</b> S/ ${data.total_ventas}
                        `,
                        icon: 'success'
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(err => Swal.fire('Error', 'Hubo un problema con el servidor', 'error'));
        }
    });
});
</script>
