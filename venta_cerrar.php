<?php
session_start();
require("modelo/m_venta.php");

$id_usuario = $_SESSION['id_usuario'] ?? 0;

$resultado = CerrarCaja($id_usuario);

// Mostrar respuesta para ver qué devuelve exactamente
echo $resultado;
?>
