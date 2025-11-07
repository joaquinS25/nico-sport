<?php 
function ListarMediopagos()
{
	require("conexion.php");

	$sql="SELECT * FROM medios_pago";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function RegistrarMediopago ($nom_mediopago)
{
    require("conexion.php");

	$sql="INSERT INTO medios_pago() VALUES(NULL,'$nom_mediopago')";
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