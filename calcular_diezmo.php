<?php
session_start();
require("modelo/m_venta.php");

// Verificamos que se envíen las fechas
if (!isset($_GET['inicio']) || !isset($_GET['fin'])) {
    echo "ERROR_FECHAS";
    exit;
}

$fecha_inicio = $_GET['inicio'];
$fecha_fin = $_GET['fin'];

$resultado = CalcularDiezmo($fecha_inicio, $fecha_fin);

echo $resultado;
