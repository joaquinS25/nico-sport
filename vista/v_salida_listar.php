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
                        <th>Pago</th>
                        <th>Accion</th>
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
                        <th>Pago</th>
                        <th>Accion</th>
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
                                <!-- COLUMNA PAGO -->
                                <td>
                                    <?php if ($value['pago'] == 'SI'): ?>
                                        <span class="badge bg-success">Pagado</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <!-- BOTÓN -->
                                <td>
                                    <?php if ($value['pago'] == 'NO'): ?>
                                        <button 
                                            class="btn btn-success btn-sm btn-pagar"
                                            data-id="<?= $value['id_salida'] ?>">
                                            Pagar
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            Pagado
                                        </button>
                                    <?php endif; ?>
                                </td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('click', function (e) {

    if (e.target.classList.contains('btn-pagar')) {

        let btn = e.target;
        let id = btn.dataset.id;

        Swal.fire({
            title: '¿Confirmar pago?',
            text: 'Esta acción no se puede revertir',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, pagar'
        }).then(result => {

            if (result.isConfirmed) {

                fetch('pagar_salida.php', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'id=' + id
                })
                .then(res => res.text())
                .then(resp => {

                    if (resp === 'OK') {
                        Swal.fire('Pagado', 'El pago fue registrado', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Error', 'No se pudo registrar el pago', 'error');
                    }
                });

            }
        });
    }
});
</script>
