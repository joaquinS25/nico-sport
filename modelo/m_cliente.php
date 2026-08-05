<?php 


function ListarClientes()
{
	require("conexion.php");

	$sql="SELECT * FROM cliente";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}

function RegistrarCliente($nom_cliente, $cel_cliente, $tienda_cliente)
{
	require("conexion.php");

	$sql="INSERT INTO cliente() VALUES(NULL,'$nom_cliente','$cel_cliente','$tienda_cliente')";
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

function EliminarCliente($id_cliente)
{
	require("conexion.php");

	$sql="DELETE FROM cliente WHERE id_cliente='$id_cliente'";
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

function ConsultarCliente($id_cliente)
{
	require("conexion.php");

	$sql="SELECT * FROM cliente WHERE id_cliente='$id_cliente'";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}

function ActualizarCliente($id_cliente,$nom_cliente,$cel_cliente,$tienda_cliente)
{
	require("conexion.php");

	$sql="UPDATE cliente SET
	nom_cliente = '$nom_cliente',
	cel_cliente = '$cel_cliente',
	tienda_cliente = '$tienda_cliente'
	WHERE id_cliente = '$id_cliente'";
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