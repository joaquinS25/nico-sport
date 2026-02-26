<?php
$totalEgresos  = 0;
$totalEfectivo = 0;
$totalYape     = 0;

if (!empty($egresos)) {
    foreach ($egresos as $value) {
        $totalEgresos  += $value['precio'];
        $totalEfectivo += $value['precio_efectivo'];
        $totalYape     += $value['precio_yape'];
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Lista de Egresos</h1>
    <h5 class="text-muted">
        Mostrando egresos del día: <b><?= $fecha ?></b>
    </h5>

    <!-- Filtro por fecha -->
    <div class="d-flex justify-content-start mb-3 gap-2">
        <input type="date" id="fechaFiltro" class="form-control w-auto">
        <button class="btn btn-primary" id="btnFiltrar">
            Filtrar
        </button>
        <button class="btn btn-secondary" id="btnHoy">
            Hoy
        </button>
    </div>

    <!-- Cards Totales -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-danger shadow">
                <div class="card-body">
                    <h6 class="card-title">Total Egresos</h6>
                    <h3>S/ <?= number_format($totalEgresos, 2) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h6 class="card-title">Egresos Efectivo</h6>
                    <h3>S/ <?= number_format($totalEfectivo, 2) ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h6 class="card-title">Egresos Yape</h6>
                    <h3>S/ <?= number_format($totalYape, 2) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i> Egresos
        </div>

        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Precio Total</th>
                        <th>Efectivo</th>
                        <th>Yape</th>
                        <th>Medio de Pago</th>
                        <th>Usuario</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $n = 0;
                    if(!empty($egresos)){
                        foreach ($egresos as $value) {
                            $n++;
                    ?>
                    <tr>
                        <td><?= $n ?></td>
                        <td><?= $value['id_egreso'] ?></td>
                        <td><?= $value['fecha'] ?></td>
                        <td><?= $value['cantidad'] ?></td>
                        <td><?= $value['descripcion'] ?></td>
                        <td>S/ <?= number_format($value['precio'],2) ?></td>
                        <td>S/ <?= number_format($value['precio_efectivo'],2) ?></td>
                        <td>S/ <?= number_format($value['precio_yape'],2) ?></td>
                        <td><?= $value['nom_medio_pago'] ?></td>
                        <td><?= $value['nom_usuario']." ".$value['ape_usuario'] ?></td>
                    </tr>
                    <?php 
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.getElementById("btnFiltrar").addEventListener("click", function () {
    let fecha = document.getElementById("fechaFiltro").value;

    if (!fecha) {
        alert("Selecciona una fecha");
        return;
    }

    window.location.href = "egreso_listar.php?fecha=" + fecha;
});

document.getElementById("btnHoy").addEventListener("click", function () {
    window.location.href = "egreso_listar.php";
});
</script>
