<?php 
function ListarVentas()
{
	require("conexion.php");

	$sql="SELECT * FROM venta v
	INNER JOIN usuario u ON v.id_usuario = u.id_usuario
	INNER JOIN medios_pago mp ON v.id_medio_pago = mp.id_medio_pago";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function RegistrarVenta($cantidad, $nom_producto, $precio_venta, $id_medio_pago, $id_usuario) 
{
   require("conexion.php");

    // Registrar venta con fecha actual y usuario logeado
	$sql = "INSERT INTO venta (cantidad, nom_producto, precio_venta, id_medio_pago, id_usuario, fecha_venta)
            VALUES ('$cantidad', '$nom_producto', '$precio_venta', '$id_medio_pago', '$id_usuario', NOW())";
            
	$res = mysqli_query($con, $sql);

	if ($res) {
		return "SI";		
	} else {
		return "NO";
	}

	mysqli_close($con);
}
?>