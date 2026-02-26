<div class="container-fluid px-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Registrar Egreso</h5>
        </div>

        <div class="card-body">
            <form method="POST">

                <div class="mb-3">
                    <label>Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>

                <div class="mb-3">
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

                <button type="submit" name="registrar" class="btn btn-danger">
                    Registrar Egreso
                </button>

            </form>
        </div>
    </div>
</div>
