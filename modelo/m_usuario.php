<?php 


function ListarUsuarios()
{
	require("conexion.php");

	$sql="SELECT * FROM usuario";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}

function RegistrarUsuario($nom_usuario, $ape_usuario, $email_usuario, $user_usuario, $pass_usuario)
{
	require("conexion.php");

	$sql="INSERT INTO usuario() VALUES(NULL,'$nom_usuario','$ape_usuario','$email_usuario','$user_usuario','$pass_usuario')";
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

function EliminarUsuario($id_usuario)
{
	require("conexion.php");

	$sql="DELETE FROM usuario WHERE id_usuario='$id_usuario'";
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

function ConsultarUsuario($id_usuario)
{
	require("conexion.php");

	$sql="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}

function ActualizarUsuario($id_usuario,$nom_usuario,$ape_usuario,$email_usuario,$user_usuario,$pass_usuario)
{
	require("conexion.php");

	$sql="UPDATE usuario SET
	nom_usuario = '$nom_usuario',
	ape_usuario = '$ape_usuario',
	email_usuario = '$email_usuario',
	user_usuario =  '$user_usuario', 
	pass_usuario =  '$pass_usuario'
	WHERE id_usuario = '$id_usuario'";
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


function ValidarUsuario($user,$pass)
{
	require("conexion.php");

	$sql="SELECT * FROM usuario 
	WHERE user_usuario = '$user' 
	AND pass_usuario = '$pass'";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}

?>