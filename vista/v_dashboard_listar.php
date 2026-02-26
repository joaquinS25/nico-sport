<form class="pt-4 px-4 py-3" method="POST">
    <h3>
        SELECCIONE MES Y AÑO 
    </h3>
    <div class="row mb-3">

        <div class="col-md-3">
            <select name="mes" class="form-control" onchange="this.form.submit()">
                <?php
                for($i=1; $i<=12; $i++){
                    $mesNumero = str_pad($i,2,"0",STR_PAD_LEFT);
                ?>
                    <option value="<?= $mesNumero ?>" 
                        <?= ($mes == $mesNumero) ? 'selected' : '' ?>>
                        <?= date("F", mktime(0,0,0,$i,1)) ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="col-md-3">
            <select name="anio" class="form-control" onchange="this.form.submit()">
                <?php
                $anioActual = date('Y');
                for($i=$anioActual; $i>=2023; $i--){
                ?>
                    <option value="<?= $i ?>" 
                        <?= ($anio == $i) ? 'selected' : '' ?>>
                        <?= $i ?>
                    </option>
                <?php } ?>
            </select>
        </div>

    </div>
</form>


<div class="container-fuid px-4 py-3">
    <div class="row">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Vendido</h6>
                <h3>S/ <?= number_format($totalVendido,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Efectivo</h6>
                <h3>S/ <?= number_format($totalEfectivo,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Total Yape</h6>
                <h3>S/ <?= number_format($totalYape,2) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">

    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5>Total Egresos</h5>
                <h3>S/ <?= number_format($totalEgresos,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5>Egresos Efectivo</h5>
                <h3>S/ <?= number_format($egresosEfectivo,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <h5>Egresos Yape</h5>
                <h3>S/ <?= number_format($egresosYape,2) ?></h3>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Ganancia Total</h5>
                <h3>S/ <?= number_format($gananciaTotal,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Ganancia Efectivo</h5>
                <h3>S/ <?= number_format($gananciaEfectivo,2) ?></h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5>Ganancia Yape</h5>
                <h3>S/ <?= number_format($gananciaYape,2) ?></h3>
            </div>
        </div>
    </div>

</div>

</div>

<div class="card mt-4">
    <div class="card-header">
        Ventas por día del mes seleccionado
    </div>
    <div class="card-body">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Total Vendido</th>
                    <th>Efectivo</th>
                    <th>Yape</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($ventasDia)) { ?>
                    <?php foreach($ventasDia as $dia) { ?>
                        <tr>
                            <td><?= $dia['fecha_cierre'] ?></td>
                            <td>S/ <?= number_format($dia['total_ventas'],2) ?></td>
                            <td>S/ <?= number_format($dia['total_efectivo'],2) ?></td>
                            <td>S/ <?= number_format($dia['total_yape'],2) ?></td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">
                            No hay ventas en este mes
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>
