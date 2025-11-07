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

function CerrarCaja($id_usuario)
{
    require("conexion.php");

    // Obtener total de ventas del día actual
    $sql_total = "SELECT SUM(precio_venta * cantidad) AS total 
                  FROM venta 
                  WHERE DATE(fecha_venta) = CURDATE()";
    $res_total = mysqli_query($con, $sql_total);
    $data = mysqli_fetch_assoc($res_total);
    $total = $data['total'] ?? 0;

    // Verificar si ya se cerró la caja hoy
    $sql_check = "SELECT * FROM cierre_caja WHERE fecha_cierre = CURDATE()";
    $res_check = mysqli_query($con, $sql_check);

    if (mysqli_num_rows($res_check) > 0) {
        return "YA_CERRADO";
    }

    // Insertar registro del cierre
    $sql_insert = "INSERT INTO cierre_caja (fecha_cierre, total_ventas, id_usuario)
                   VALUES (CURDATE(), '$total', '$id_usuario')";
    $res_insert = mysqli_query($con, $sql_insert);

    if ($res_insert) {
        return "OK";
    } else {
        return "ERROR";
    }

    mysqli_close($con);
}

?>