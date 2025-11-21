<?php 
function ListarSalida()
{
	require("conexion.php");

	$sql="SELECT * FROM salida_mercaderia";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function RegistrarSalida($nombre,$cantidad,$producto,$precio,$fecha_registro)
{
    require("conexion.php");

	$sql="INSERT INTO salida_mercaderia() VALUES(NULL,'$nombre','$cantidad','$producto','$precio','$fecha_registro')";
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
?>