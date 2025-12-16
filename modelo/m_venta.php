<?php 
function ListarVentas()
{
	require("conexion.php");
	$sql="SELECT * FROM venta v
	INNER JOIN usuario u ON v.id_usuario = u.id_usuario
	INNER JOIN medios_pago mp ON v.id_medio_pago = mp.id_medio_pago";
	$res = mysqli_query($con,$sql);
	$datos = array();
	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
		$datos[] = $fila;
	}
	return $datos;
	mysqli_close($con);
}

function RegistrarVenta($cantidad, $nom_producto, $precio_venta, $id_medio_pago, $id_usuario) 
{
    require("conexion.php");

    // Buscar el nombre del medio de pago
    $sql_medio = "SELECT nom_medio_pago FROM medios_pago WHERE id_medio_pago = '$id_medio_pago'";
    $res_medio = mysqli_query($con, $sql_medio);
    $row = mysqli_fetch_assoc($res_medio);
    $nombre_medio = strtolower($row['nom_medio_pago']);

    // Inicializar montos
    $precio_efectivo = 0;
    $precio_yape = 0;

    if ($nombre_medio == 'mixto') {
        $precio_efectivo = $_POST['precio_efectivo'] ?? 0;
        $precio_yape = $_POST['precio_yape'] ?? 0;
        $precio_venta = $precio_efectivo + $precio_yape;
    } else {
        if ($nombre_medio == 'efectivo') {
            $precio_efectivo = $precio_venta;
        } elseif ($nombre_medio == 'yape') {
            $precio_yape = $precio_venta;
        }
    }

    $sql = "INSERT INTO venta (cantidad, nom_producto, precio_venta, precio_efectivo, precio_yape, id_medio_pago, id_usuario, fecha_venta)
            VALUES ('$cantidad', '$nom_producto', '$precio_venta', '$precio_efectivo', '$precio_yape', '$id_medio_pago', '$id_usuario', NOW())";
            
	$res = mysqli_query($con, $sql);

	if ($res) {
		return "SI";		
	} else {
		return "NO";
	}

	mysqli_close($con);
}

function CalcularDiezmo($fecha_inicio, $fecha_fin)
{
    require("conexion.php");

    // 1️⃣ Sumar todas las ventas de los cierres entre las fechas indicadas
    $sql_total = "SELECT SUM(total_ventas) AS total 
                  FROM cierre_caja 
                  WHERE fecha_cierre BETWEEN '$fecha_inicio' AND '$fecha_fin'";
    $res_total = mysqli_query($con, $sql_total);

    if (!$res_total) {
        return "Error al calcular total: " . mysqli_error($con);
    }

    $data = mysqli_fetch_assoc($res_total);
    $total = $data['total'] ?? 0;

    // 2️⃣ Calcular el diezmo
    $intermedio = $total * 0.15;
    $diezmo = $intermedio * 0.10;

    // 3️⃣ Insertar el resultado en la tabla diezmo
    $sql_insert = "INSERT INTO diezmo (fecha_inicio, fecha_fin, monto_diezmo)
                   VALUES ('$fecha_inicio', '$fecha_fin', '$diezmo')";
    $res_insert = mysqli_query($con, $sql_insert);

    if ($res_insert) {
        return "OK";
    } else {
        return "Error al registrar diezmo: " . mysqli_error($con);
    }

    mysqli_close($con);
}
function ListarDiezmo()
{
    require("conexion.php");

	$sql="SELECT * FROM diezmo";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function ListarCierreCaja()
{
require("conexion.php");

	$sql="SELECT * FROM cierre_caja cc
	INNER JOIN usuario u ON cc.id_usuario = u.id_usuario";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

	return $datos;

	mysqli_close($con);
}
function CerrarCaja($id_usuario, $fecha = null)
{
    require("conexion.php");

    if ($fecha === null) {
        $fecha = date('Y-m-d');
    }

    // ✅ Paso 1: Calcular totales (ventas, yape, efectivo)
    $sql_total = "SELECT
        SUM(v.precio_venta) AS total_ventas,

        SUM(
            CASE
                WHEN mp.nom_medio_pago = 'Yape' THEN v.precio_venta
                WHEN mp.nom_medio_pago = 'Mixto' THEN v.precio_yape
                ELSE 0
            END
        ) AS total_yape,

        SUM(
            CASE
                WHEN mp.nom_medio_pago = 'Efectivo' THEN v.precio_venta
                WHEN mp.nom_medio_pago = 'Mixto' THEN v.precio_efectivo
                ELSE 0
            END
        ) AS total_efectivo

    FROM venta v
    INNER JOIN medios_pago mp ON v.id_medio_pago = mp.id_medio_pago
    WHERE DATE(v.fecha_venta) = '$fecha'";

    $res_total = mysqli_query($con, $sql_total);
    if (!$res_total) {
        return "Error al calcular total: " . mysqli_error($con);
    }

    $data = mysqli_fetch_assoc($res_total);

    $total_ventas   = $data['total_ventas'] ?? 0;
    $total_yape     = $data['total_yape'] ?? 0;
    $total_efectivo = $data['total_efectivo'] ?? 0;

    // ✅ Paso 2: Verificar si ya se cerró esa fecha
    $sql_check = "SELECT 1 FROM cierre_caja WHERE fecha_cierre = '$fecha' LIMIT 1";
    $res_check = mysqli_query($con, $sql_check);

    if (!$res_check) {
        return "Error al verificar cierre: " . mysqli_error($con);
    }

    if (mysqli_num_rows($res_check) > 0) {
        return "YA_CERRADO";
    }

    // ✅ Paso 3: Insertar cierre (con Yape/Efectivo)
    $sql_insert = "INSERT INTO cierre_caja (fecha_cierre, total_ventas, total_yape, total_efectivo, id_usuario)
                   VALUES ('$fecha', '$total_ventas', '$total_yape', '$total_efectivo', '$id_usuario')";

    $res_insert = mysqli_query($con, $sql_insert);

    if (!$res_insert) {
        return "Error al insertar cierre: " . mysqli_error($con);
    }

    return "OK";
}


?>