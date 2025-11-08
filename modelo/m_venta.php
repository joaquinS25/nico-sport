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

function CerrarCaja($id_usuario, $fecha = null)
{
    require("conexion.php");

    // Si no se envía fecha, usar la fecha actual
    if ($fecha === null) {
        $fecha = date('Y-m-d');
    }

    // Paso 1: Calcular total del día indicado
    $sql_total = "SELECT SUM(precio_venta) AS total 
                  FROM venta 
                  WHERE DATE(fecha_venta) = '$fecha'";
    $res_total = mysqli_query($con, $sql_total);

    if (!$res_total) {
        return "Error al calcular total: " . mysqli_error($con);
    }

    $data = mysqli_fetch_assoc($res_total);
    $total = $data['total'] ?? 0;

    // Paso 2: Verificar si ya se cerró esa fecha
    $sql_check = "SELECT * FROM cierre_caja WHERE fecha_cierre = '$fecha'";
    $res_check = mysqli_query($con, $sql_check);

    if (mysqli_num_rows($res_check) > 0) {
        return "YA_CERRADO";
    }

    // Paso 3: Insertar cierre
    $sql_insert = "INSERT INTO cierre_caja (fecha_cierre, total_ventas, id_usuario)
                   VALUES ('$fecha', '$total', '$id_usuario')";
    $res_insert = mysqli_query($con, $sql_insert);

    if (!$res_insert) {
        return "Error al insertar cierre: " . mysqli_error($con);
    }

    return "OK";
}


?>