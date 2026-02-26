<?php 
function ListarVentasPorFecha($fecha)
{
    require("conexion.php");

    $sql = "SELECT v.*, 
                   mp.nom_medio_pago, 
                   u.nom_usuario, 
                   u.ape_usuario
            FROM venta v
            INNER JOIN medios_pago mp ON v.id_medio_pago = mp.id_medio_pago
            INNER JOIN usuario u ON v.id_usuario = u.id_usuario
            WHERE DATE(v.fecha_venta) = '$fecha'
            ORDER BY v.fecha_venta DESC";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("Error SQL: " . mysqli_error($con));
    }

    $datos = [];
    while ($fila = mysqli_fetch_assoc($res)) {
        $datos[] = $fila;
    }

    return $datos;
}

function TotalCierrePorMes($mes, $anio)
{
    require("conexion.php");

    $fecha_inicio = "$anio-$mes-01";
    $fecha_fin = date("Y-m-t", strtotime($fecha_inicio));

    $sql = "SELECT 
                SUM(total_ventas) AS total_ventas,
                SUM(total_efectivo) AS total_efectivo,
                SUM(total_yape) AS total_yape,

                SUM(total_egresos) AS total_egresos,
                SUM(egresos_yape) AS egresos_yape,
                SUM(egresos_efectivo) AS egresos_efectivo,

                SUM(ganancia_total) AS ganancia_total,
                SUM(ganancia_yape) AS ganancia_yape,
                SUM(ganancia_efectivo) AS ganancia_efectivo

            FROM cierre_caja
            WHERE fecha_cierre BETWEEN '$fecha_inicio' AND '$fecha_fin'";

    $res = mysqli_query($con, $sql);

    if(!$res){
        die("Error en SQL: " . mysqli_error($con));
    }

    $data = mysqli_fetch_assoc($res);
    mysqli_close($con);
    return $data;
}
function ExisteCierre($fecha)
{
    require("conexion.php");

    $sql = "SELECT COUNT(*) as total FROM cierre_caja WHERE fecha_cierre = '$fecha'";
    $res = mysqli_query($con, $sql);
    $fila = mysqli_fetch_assoc($res);

    return $fila['total'] > 0;
}

function CierresPorDia($mes, $anio)
{
    require("conexion.php");

    $fecha_inicio = "$anio-$mes-01";
    $fecha_fin = date("Y-m-t", strtotime($fecha_inicio));

    $sql = "SELECT 
                fecha_cierre,
                total_ventas,
                total_efectivo,
                total_yape
            FROM cierre_caja
            WHERE fecha_cierre BETWEEN '$fecha_inicio' AND '$fecha_fin'
            ORDER BY fecha_cierre ASC";

    $res = mysqli_query($con, $sql);

    $datos = [];
    while($fila = mysqli_fetch_assoc($res)){
        $datos[] = $fila;
    }

    mysqli_close($con);
    return $datos;
}


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

function ConsultarVenta($id_venta)
{
	require("conexion.php");

	$sql="SELECT * FROM venta WHERE id_venta='$id_venta'";
	$res = mysqli_query($con,$sql);

	$datos = array();

	while ($fila = mysqli_fetch_array($res,MYSQLI_ASSOC)) 
	{
		$datos[] = $fila;
	}

    mysqli_close($con);
	return $datos;
}

function ActualizarVenta($id_venta,$cantidad,$nom_producto,$precio_venta,$precio_efectivo,$precio_yape, $id_medio_pago)
{
	require("conexion.php");

	$sql="UPDATE venta SET
	cantidad = '$cantidad',
    nom_producto = '$nom_producto',
	precio_venta = '$precio_venta',
	precio_efectivo =  '$precio_efectivo', 
	precio_yape =  '$precio_yape',
    id_medio_pago = '$id_medio_pago'
	WHERE id_venta = '$id_venta'";
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

    // =============================
    // 1️⃣ TOTALES DE VENTAS
    // =============================
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
        return "Error ventas: " . mysqli_error($con);
    }

    $data = mysqli_fetch_assoc($res_total);

    $total_ventas   = $data['total_ventas'] ?? 0;
    $total_yape     = $data['total_yape'] ?? 0;
    $total_efectivo = $data['total_efectivo'] ?? 0;

    // =============================
    // 2️⃣ TOTALES DE EGRESOS
    // =============================
    $sql_egresos = "SELECT
        SUM(e.precio) AS total_egresos,

        SUM(
            CASE
                WHEN mp.nom_medio_pago = 'Yape' THEN e.precio
                ELSE 0
            END
        ) AS egresos_yape,

        SUM(
            CASE
                WHEN mp.nom_medio_pago = 'Efectivo' THEN e.precio
                ELSE 0
            END
        ) AS egresos_efectivo

    FROM egresos e
    INNER JOIN medios_pago mp ON e.id_medio_pago = mp.id_medio_pago
    WHERE DATE(e.fecha) = '$fecha'";

    $res_egresos = mysqli_query($con, $sql_egresos);
    if (!$res_egresos) {
        return "Error egresos: " . mysqli_error($con);
    }

    $data_e = mysqli_fetch_assoc($res_egresos);

    $total_egresos     = $data_e['total_egresos'] ?? 0;
    $egresos_yape      = $data_e['egresos_yape'] ?? 0;
    $egresos_efectivo  = $data_e['egresos_efectivo'] ?? 0;

    // =============================
    // 3️⃣ CALCULAR GANANCIAS
    // =============================
    $ganancia_total     = $total_ventas - $total_egresos;
    $ganancia_yape      = $total_yape - $egresos_yape;
    $ganancia_efectivo  = $total_efectivo - $egresos_efectivo;

    // =============================
    // 4️⃣ VERIFICAR SI YA CERRÓ
    // =============================
    $sql_check = "SELECT 1 FROM cierre_caja WHERE fecha_cierre = '$fecha' LIMIT 1";
    $res_check = mysqli_query($con, $sql_check);

    if (mysqli_num_rows($res_check) > 0) {
        return "YA_CERRADO";
    }

    // =============================
    // 5️⃣ INSERTAR CIERRE COMPLETO
    // =============================
    $sql_insert = "INSERT INTO cierre_caja (
        fecha_cierre,
        total_ventas,
        total_yape,
        total_efectivo,
        total_egresos,
        egresos_yape,
        egresos_efectivo,
        ganancia_total,
        ganancia_yape,
        ganancia_efectivo,
        id_usuario
    ) VALUES (
        '$fecha',
        '$total_ventas',
        '$total_yape',
        '$total_efectivo',
        '$total_egresos',
        '$egresos_yape',
        '$egresos_efectivo',
        '$ganancia_total',
        '$ganancia_yape',
        '$ganancia_efectivo',
        '$id_usuario'
    )";

    $res_insert = mysqli_query($con, $sql_insert);

    if (!$res_insert) {
        return "Error insertar cierre: " . mysqli_error($con);
    }

    return "OK";
}


?>