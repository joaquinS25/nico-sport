<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Entrada de Mercaderia</h1>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
                Entrada de Mercaderia
        </div>
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" id="btnPagarDeuda">
                💰 Pagar Deuda
            </button>
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
            <tfoot>
                    <h3 class="text-end mt-3">
                        Deuda Total: 
                        <b style="color:red;">S/ 
                            <?php require_once("modelo/m_mercaderia_entrada.php"); echo ObtenerDeudaTotal(); ?>
                        </b>
                        </h3>
                </tfoot>
           

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("btnPagarDeuda").addEventListener("click", function() {

    Swal.fire({
        title: "Registrar Pago",
        html: `
            <p>Monto a pagar:</p>
            <input id="montoPago" type="number" class="swal2-input" min="0.10" step="0.10">
        `,
        showCancelButton: true,
        confirmButtonText: "Pagar"
    }).then(result => {

        if (result.isConfirmed) {

            let monto = parseFloat(document.getElementById("montoPago").value);

            if (!monto || monto <= 0) {
                Swal.fire("Error", "Ingresa un monto válido", "error");
                return;
            }

            fetch("registrar_pago_entrada_total.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "monto=" + monto
            })
            .then(r => r.text())
            .then(resp => {
                Swal.fire("Pago registrado", "La deuda se ha actualizado", "success")
                    .then(() => location.reload());
            });
        }

    });
});
</script>
