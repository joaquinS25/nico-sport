<div class="container-fluid px-4">

    <h1 class="mt-4">Venta</h1>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Venta</li>
    </ol>

    <!-- ✅ CARD EXACTAMENTE IGUAL A MEDIOS DE PAGO -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Registro de Venta
        </div>

        <div class="card-body">

            <form action="venta_registrar.php" method="post">

                <!-- ✅ NO row externa que rompe layout -->
                <div class="row g-3">

                    <div class="col-md-6">
                        <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required>
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="nom_producto" class="form-control" placeholder="Nombre del Producto" required>
                    </div>

                    <div class="col-md-6">
                        <input type="number" step="0.01" name="precio_venta" class="form-control" placeholder="Precio" required>
                    </div>

                    <div class="col-md-6">
                        <select name="id_medio_pago" class="form-control" required>
                            <option value="" disabled selected>Seleccione medio de pago</option>
                            <?php foreach ($mediopago as $value) { ?>
                                <option value="<?= $value['id_medio_pago'] ?>">
                                    <?= $value['nom_medio_pago'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <button type="submit" name="registrar" class="btn btn-primary">
                            Registrar Venta
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>
