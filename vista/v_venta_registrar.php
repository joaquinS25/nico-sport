<div class="container-fluid px-4">
    <h1 class="mt-4">Registrar Venta</h1>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-shopping-cart me-1"></i> Nueva Venta
        </div>

        <div class="card-body">
            <form action="venta_registrar.php" method="post">

                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="nom_producto" class="form-control" placeholder="Nombre del Producto" required>
                    </div>

                    <div class="col-md-6">
                        <select id="medio_pago" name="id_medio_pago" class="form-control" required>
                            <option value="" disabled selected>Seleccione medio de pago</option>
                            <?php foreach ($mediopago as $value) { ?>
                                <option value="<?= $value['id_medio_pago'] ?>">
                                    <?= $value['nom_medio_pago'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Campo de precio normal -->
                    <div id="campo_precio" class="col-md-6">
                        <input type="number" step="0.01" id="precio_venta" name="precio_venta" class="form-control" placeholder="Precio" required>
                    </div>

                    <!-- Campos para pago mixto -->
                    <div id="campos_mixtos" class="col-md-12" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="precio_efectivo" name="precio_efectivo" class="form-control" placeholder="Monto en Efectivo">
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="precio_yape" name="precio_yape" class="form-control" placeholder="Monto en Yape">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" name="registrar" class="btn btn-primary mt-3">
                            Registrar Venta
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('medio_pago').addEventListener('change', function() {
    const medio = this.options[this.selectedIndex].text.trim().toLowerCase();
    const campoPrecio = document.getElementById('campo_precio');
    const camposMixtos = document.getElementById('campos_mixtos');
    const precioVenta = document.getElementById('precio_venta');
    const precioEfectivo = document.getElementById('precio_efectivo');
    const precioYape = document.getElementById('precio_yape');

    if (medio === 'mixto') {
        campoPrecio.style.display = 'none';
        camposMixtos.style.display = 'block';
        precioVenta.removeAttribute('required');
        precioEfectivo.setAttribute('required', true);
        precioYape.setAttribute('required', true);
    } else {
        campoPrecio.style.display = 'block';
        camposMixtos.style.display = 'none';
        precioVenta.setAttribute('required', true);
        precioEfectivo.removeAttribute('required');
        precioYape.removeAttribute('required');
    }
});
</script>
