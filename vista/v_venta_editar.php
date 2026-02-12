<div class="container-fluid px-4">
    <h1 class="mt-4">Ventas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Ventas</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Edición de Venta
        </div>
        <div class="card-body">


            <form action="venta_editar.php" method="post">

                <input type="hidden" name="id_venta" value="<?php echo $id_venta; ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="number" name="cantidad" value="<?php echo $cantidad; ?>"class="form-control" placeholder="Cantidad" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="nom_producto" value="<?php echo $nom_producto; ?>" class="form-control" placeholder="Nombre del Producto" required>
                    </div>

                    <div class="col-md-6">
                        <select id="medio_pago" name="id_medio_pago" class="form-control" required>
                            <?php foreach ($mediopago as $value) { ?>
                                <option value="<?= $value['id_medio_pago'] ?>"
                                    <?= ($value['id_medio_pago'] == $id_medio_pago) ? 'selected' : '' ?>>
                                    <?= $value['nom_medio_pago'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Campo de precio normal -->
                    <div id="campo_precio" class="col-md-6">
                        <input type="number" step="0.01" id="precio_venta" name="precio_venta" value="<?php echo $precio_venta; ?>" class="form-control" placeholder="Precio" required>
                    </div>

                    <!-- Campos para pago mixto -->
                    <div id="campos_mixtos" class="col-md-12" style="display: none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="precio_efectivo"  name="precio_efectivo" value="<?php echo $precio_efectivo; ?>" class="form-control" placeholder="Monto en Efectivo">
                            </div>
                            <div class="col-md-6">
                                <input type="number" step="0.01" id="precio_yape" name="precio_yape" value="<?php echo $precio_yape; ?>" class="form-control" placeholder="Monto en Yape">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" name="actualizar" class="btn btn-primary mt-3">
                            Actualizar Venta
                        </button>
                    </div>
                </div>

            </form>

    


        </div>
    </div>  
</div>      
<script>
document.addEventListener("DOMContentLoaded", function() {

    const medioSelect = document.getElementById('medio_pago');
    const campoPrecio = document.getElementById('campo_precio');
    const camposMixtos = document.getElementById('campos_mixtos');
    const precioVenta = document.getElementById('precio_venta');
    const precioEfectivo = document.getElementById('precio_efectivo');
    const precioYape = document.getElementById('precio_yape');

    function verificarMedioPago() {
        const medio = medioSelect.options[medioSelect.selectedIndex].text.trim().toLowerCase();

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
    }

    // 👇 IMPORTANTE: ejecutar al cargar
    verificarMedioPago();

    // 👇 ejecutar cuando cambie
    medioSelect.addEventListener('change', verificarMedioPago);

});
</script>