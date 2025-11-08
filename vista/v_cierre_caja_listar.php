<div class="container-fluid px-4">
    <h1 class="mt-4">Cierre de Caja</h1>
    <div class="d-flex justify-content-end align-items-center mb-3 gap-2">
        <div class="d-flex justify-content-end mb-3">
            <input type="date" id="fechaInicio" class="form-control me-2" style="width: 180px;">
            <input type="date" id="fechaFin" class="form-control me-2" style="width: 180px;">
            <button id="btnCalcularDiezmo" class="btn btn-success">
                <i class="fas fa-coins"></i> Calcular Diezmo
            </button>
        </div>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btnCalcularDiezmo').addEventListener('click', function() {
    const inicio = document.getElementById('fechaInicio').value;
    const fin = document.getElementById('fechaFin').value;

    if (!inicio || !fin) {
        Swal.fire('Advertencia', 'Selecciona ambas fechas.', 'warning');
        return;
    }

    Swal.fire({
        title: '¿Calcular diezmo?',
        text: `Desde ${inicio} hasta ${fin}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, calcular',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`calcular_diezmo.php?inicio=${inicio}&fin=${fin}`)
                .then(response => response.text())
                .then(data => {
                    if (data === 'OK') {
                        Swal.fire('Listo', 'El diezmo se calculó y guardó correctamente.', 'success');
                    } else {
                        Swal.fire('Error', data, 'error');
                    }
                })
                .catch(() => Swal.fire('Error', 'No se pudo conectar con el servidor.', 'error'));
        }
    });
});
</script>
