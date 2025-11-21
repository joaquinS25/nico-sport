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
?>