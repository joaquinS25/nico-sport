<div class="container-fluid px-4">
    <h1 class="mt-4">Salida de Mercaderia</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Salida de Mercaderia</li>
    </ol>

    <div class="card mb-4">
       <div class="card-header">
            <i class="fas fa-table me-1"></i>Registro de Salida de Mercaderia
        </div>
        <div class="card-body">

            <form action="salida_registrar.php" method="post">

                <div class="row g-3">

                  <div class="col-md-6">
                        <select id="cliente" name="id_cliente" class="form-control" required>
                            <option value="" disabled selected>Seleccione cliente</option>
                            <?php foreach ($cliente as $value) { ?>
                                <option value="<?= $value['id_cliente'] ?>">
                                    <?= $value['nom_cliente'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                  <div class="col-md-6">
                    <input type="number" id="cantidad" name="cantidad" class="form-control"
                           placeholder="Cantidad (pares)" aria-label="Cantidad"
                           min="1" step="any" required="required">
                  </div>

                  <div class="col-md-6">
                    <input type="text" name="producto" class="form-control"
                           placeholder="Producto" aria-label="Producto" required="required">
                  </div>

                  <div class="col-md-6">
                    <input type="number" id="precio_unitario" name="precio_unitario" class="form-control"
                           placeholder="Precio unitario (S/)" aria-label="Precio unitario"
                           min="0" step="0.01" required="required">
                  </div>

                  <div class="col-md-6">
                    <input type="text" id="precio" name="precio" class="form-control"
                           placeholder="Precio total (S/)" aria-label="Precio"
                           readonly required="required">
                  </div>

                  <div class="col-md-6">
                    <input type="date" name="fecha_registro" class="form-control"
                           placeholder="Fecha de Registro" aria-label="Fecha de Registro" required="required">
                  </div>

                  <div class="col-md-12">
                    <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
                  </div>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
    const inputCantidad = document.getElementById('cantidad');
    const inputUnitario = document.getElementById('precio_unitario');
    const inputPrecio   = document.getElementById('precio');

    function calcularPrecio() {
        const cantidad = parseFloat(inputCantidad.value) || 0;
        const unitario = parseFloat(inputUnitario.value) || 0;
        const total    = cantidad * unitario;

        inputPrecio.value = total > 0 ? total.toFixed(2) : '';
    }

    inputCantidad.addEventListener('input', calcularPrecio);
    inputUnitario.addEventListener('input', calcularPrecio);
</script>