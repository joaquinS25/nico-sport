<?php
session_start();
require("modelo/m_venta.php");

$id_usuario = $_SESSION['id_session'] ?? 0;
$fecha = $_POST['fecha'] ?? date('Y-m-d');

echo CerrarCaja($id_usuario, $fecha);
?>
