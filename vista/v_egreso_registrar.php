<div class="container-fluid px-4">
    <h1 class="mt-4">Registrar Venta</h1>
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Registrar Egreso</h5>
        </div>

        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Descripción</label>
                        <input type="text" name="descripcion" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Precio</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Medio de Pago</label>
                        <select name="id_medio_pago" class="form-control" required>
                            <option value="">Seleccione</option>
                            <?php foreach($mediopago as $mp){ ?>
                                <option value="<?= $mp['id_medio_pago'] ?>">
                                    <?= $mp['nom_medio_pago'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                   <div class="col-md-6">
                        <button type="submit" name="registrar" class="btn btn-danger mt-3">
                            Registrar Egreso
                        </button>
                   </div>
                </div>
                

            </form>
        </div>
    </div>
</div>
