<?php
session_start();

require("modelo/m_venta.php");

if (!isset($_SESSION['id_session'])) {
    echo "ERROR_USUARIO";
    exit;
}

$id_usuario = $_SESSION['id_session'];
$fecha = $_POST['fecha'] ?? null;

if (!$fecha) {
    echo "ERROR_FECHA";
    exit;
}

// 👇 LLAMAMOS A LA FUNCIÓN REAL
$resultado = CerrarCaja($id_usuario, $fecha);

echo $resultado;
?>
