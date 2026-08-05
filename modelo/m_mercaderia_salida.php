<?php 
function MarcarPago($id)
{
    require("conexion.php");

    $sql = "UPDATE salida_mercaderia SET pago='SI' WHERE id_salida = '$id'";
    $res = mysqli_query($con, $sql);

    return $res ? "OK" : "ERROR";
}
/*function ListarSalida()
{
	require("conexion.php");
	$sql="SELECT * FROM salida_mercaderia sm
	INNER JOIN cliente c ON sm.id_cliente = c.id_cliente";
	$res = mysqli_query($con,$sql);
	$datos = array();
	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
		$datos[] = $fila;
	}
	return $datos;
	mysqli_close($con);
}*/
function ListarSalida()
{
    require("conexion.php");

    $sql = "SELECT sm.*, c.nom_cliente
            FROM salida_mercaderia sm
            INNER JOIN cliente c ON sm.id_cliente = c.id_cliente";

    $res = mysqli_query($con, $sql);

    if(!$res)
    {
        die("ERROR SQL: " . mysqli_error($con));
    }

    $datos = array();

    while ($fila = mysqli_fetch_array($res, MYSQLI_ASSOC))
    {
        $datos[] = $fila;
    }

    mysqli_close($con);

    return $datos;
}
function RegistrarSalida($id_cliente, $cantidad, $producto, $precio, $fecha_registro)
{
    require("conexion.php");

    $sql = "INSERT INTO salida_mercaderia
    (id_cliente, cantidad, producto, precio, fecha_registro)
    VALUES
    ('$id_cliente', '$cantidad', '$producto', '$precio', '$fecha_registro')";

    $res = mysqli_query($con, $sql);

    if(!$res)
    {
        die(mysqli_error($con));
    }

    mysqli_close($con);

    return "SI";
}
?>