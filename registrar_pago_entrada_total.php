<?php
require("modelo/conexion.php"); // SOLO ESTA conexión

if (!isset($_POST["monto"])) {

    echo "ERROR_MONTO";
    exit;
}

$monto = floatval($_POST["monto"]);
$fecha = date("Y-m-d");

// Insertar el pago
$sql = "INSERT INTO pagos_entrada_total (monto_pagado, fecha_pago)
        VALUES ('$monto', '$fecha')";

$res = mysqli_query($con, $sql);

if ($res) {
    echo "OK";
} else {
    echo "ERROR_DB";
}

mysqli_close($con);
?>
