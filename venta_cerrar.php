<?php
session_start();
require("modelo/m_venta.php");

$id_usuario = $_SESSION['id_usuario'];

$res = CerrarCaja($id_usuario);

echo $res;
?>
