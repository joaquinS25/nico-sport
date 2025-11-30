<?php 
function ListarEntrada()
{
	require("conexion.php");

	$sql="SELECT * FROM entrada_mercaderia";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function RegistrarEntrada($cantidad,$producto,$precio,$proveedor,$fecha_registro)
{
    require("conexion.php");

	$sql="INSERT INTO entrada_mercaderia() VALUES(NULL,'$cantidad','$producto','$precio','$proveedor','$fecha_registro')";
	$res = mysqli_query($con,$sql);

	if($res)
	{
		return "SI";		
	}
	else
	{
		return "NO";
	}

	mysqli_close($con);
}
function ObtenerDeudaTotal()
{
    require("conexion.php");

    $sql = "SELECT SUM(precio) AS total FROM entrada_mercaderia";
    $res = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($res);

    // Obtener pagos realizados
    $sql2 = "SELECT SUM(monto_pagado) AS pagado FROM pagos_entrada_total";
    $res2 = mysqli_query($con, $sql2);
    $data2 = mysqli_fetch_assoc($res2);

    $total = $data['total'] ?? 0;
    $pagado = $data2['pagado'] ?? 0;

    return $total - $pagado;
}

?>