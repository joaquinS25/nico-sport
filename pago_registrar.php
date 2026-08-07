<?php

require("modelo/m_mercaderia_salida.php");

if (
    !isset($_POST['id_cliente']) ||
    !isset($_POST['monto']) ||
    !isset($_POST['fecha_pago'])
) {
    echo "ERROR: faltan_datos";
    exit;
}

$id_cliente = $_POST['id_cliente'];
$monto = $_POST['monto'];
$fecha_pago = $_POST['fecha_pago'];

// DEBUG
if (empty($id_cliente)) {
    echo "ERROR: id_cliente_vacio";
    exit;
}

if (!is_numeric($id_cliente)) {
    echo "ERROR: id_cliente_no_numerico: " . $id_cliente;
    exit;
}

$rpta = RegistrarPagoCliente(
    $id_cliente,
    $monto,
    $fecha_pago
);

echo $rpta;