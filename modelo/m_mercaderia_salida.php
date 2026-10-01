<?php
// =====================================================
// LISTAR SALIDA DE MERCADERÍA
// total_pagado = solo pagos de la cuenta abierta (liquidado = 0)
// =====================================================

function ListarSalida()
{
    require("conexion.php");

    $sql = "SELECT 
                sm.id_salida,
                sm.id_cliente,
                c.nom_cliente,
                c.cel_cliente,
                sm.cantidad,
                sm.producto,
                sm.precio,
                sm.fecha_registro,
                sm.pago,

                COALESCE(p.total_pagado, 0) AS total_pagado

            FROM salida_mercaderia sm

            INNER JOIN cliente c 
                ON sm.id_cliente = c.id_cliente

            LEFT JOIN (
                SELECT 
                    id_cliente,
                    SUM(monto) AS total_pagado
                FROM pagos_cliente
                WHERE liquidado = 0
                GROUP BY id_cliente
            ) p 
                ON p.id_cliente = sm.id_cliente

            ORDER BY sm.id_salida DESC";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("ERROR SQL: " . mysqli_error($con));
    }

    $datos = array();

    while ($fila = mysqli_fetch_assoc($res)) {

        // Asegurar que siempre sea numérico
        $fila['total_pagado'] = floatval($fila['total_pagado']);

        $datos[] = $fila;
    }

    mysqli_close($con);

    return $datos;
}


// =====================================================
// REGISTRAR SALIDA (consulta preparada)
// =====================================================

function RegistrarSalida(
    $id_cliente,
    $cantidad,
    $producto,
    $precio,
    $fecha_registro
)
{
    require("conexion.php");

    $id_cliente = intval($id_cliente);

    $sql = "INSERT INTO salida_mercaderia
            (id_cliente, cantidad, producto, precio, fecha_registro, pago)
            VALUES (?, ?, ?, ?, ?, 'NO')";

    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt) {
        $error = mysqli_error($con);
        mysqli_close($con);
        die("ERROR SQL: " . $error);
    }

    $cantidad       = (string)$cantidad;
    $producto       = (string)$producto;
    $precio         = (string)$precio;
    $fecha_registro = (string)$fecha_registro;

    mysqli_stmt_bind_param(
        $stmt,
        "issss",
        $id_cliente,
        $cantidad,
        $producto,
        $precio,
        $fecha_registro
    );

    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($con);
        die("ERROR SQL: " . $error);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return "SI";
}


// =====================================================
// REGISTRAR PAGO DEL CLIENTE
//
// - Cuenta abierta = productos con pago = 'NO'
// - Cada pago se suma a lo pagado de la cuenta
// - Solo cuando lo pagado alcanza el total:
//     * los productos pasan a pago = 'SI'
//     * los pagos pasan a liquidado = 1
//   (el historial de pagos NO se borra)
// =====================================================

function RegistrarPagoCliente($id_cliente, $monto, $fecha_pago)
{
    require("conexion.php");

    $id_cliente = intval($id_cliente);
    $monto      = floatval($monto);
    $fecha_pago = trim($fecha_pago);

    if ($id_cliente <= 0) {
        mysqli_close($con);
        return "ERROR: ID_CLIENTE_INVALIDO";
    }

    if ($monto <= 0) {
        mysqli_close($con);
        return "ERROR: MONTO_INVALIDO";
    }

    if (empty($fecha_pago)) {
        mysqli_close($con);
        return "ERROR: FECHA_INVALIDA";
    }

    mysqli_begin_transaction($con);

    try {

        // 1) Total de la cuenta abierta
        $stmt = mysqli_prepare($con,
            "SELECT COALESCE(SUM(precio), 0)
             FROM salida_mercaderia
             WHERE id_cliente = ? AND pago = 'NO'
             FOR UPDATE");

        if (!$stmt) {
            throw new Exception("ERROR_SQL_PREPARE: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($stmt, "i", $id_cliente);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $total);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // 2) Pagos acumulados de la cuenta abierta
        $stmt = mysqli_prepare($con,
            "SELECT COALESCE(SUM(monto), 0)
             FROM pagos_cliente
             WHERE id_cliente = ? AND liquidado = 0");

        if (!$stmt) {
            throw new Exception("ERROR_SQL_PREPARE: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($stmt, "i", $id_cliente);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $pagado);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $total  = (float)$total;
        $pagado = (float)$pagado;
        $saldo  = round($total - $pagado, 2);

        if ($total <= 0) {
            throw new Exception("ERROR: SIN_DEUDA_PENDIENTE");
        }

        if ($monto > $saldo + 0.005) {
            throw new Exception(
                "ERROR: EL_MONTO_SUPERA_EL_SALDO (S/ " . number_format($saldo, 2) . ")"
            );
        }

        // 3) Registrar el pago
        $stmt = mysqli_prepare($con,
            "INSERT INTO pagos_cliente (id_cliente, monto, fecha_pago, liquidado)
             VALUES (?, ?, ?, 0)");

        if (!$stmt) {
            throw new Exception("ERROR_SQL_PREPARE: " . mysqli_error($con));
        }

        mysqli_stmt_bind_param($stmt, "ids", $id_cliente, $monto, $fecha_pago);

        if (!mysqli_stmt_execute($stmt)) {
            $e = mysqli_stmt_error($stmt);
            mysqli_stmt_close($stmt);
            throw new Exception("ERROR_SQL_EXECUTE: " . $e);
        }

        mysqli_stmt_close($stmt);

        // 4) Si con este pago se completa la cuenta, se limpia la lista
        if ($pagado + $monto >= $total - 0.005) {

            $stmt = mysqli_prepare($con,
                "UPDATE salida_mercaderia
                 SET pago = 'SI'
                 WHERE id_cliente = ? AND pago = 'NO'");
            mysqli_stmt_bind_param($stmt, "i", $id_cliente);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $stmt = mysqli_prepare($con,
                "UPDATE pagos_cliente
                 SET liquidado = 1
                 WHERE id_cliente = ? AND liquidado = 0");
            mysqli_stmt_bind_param($stmt, "i", $id_cliente);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        mysqli_commit($con);
        mysqli_close($con);

        return "SI";

    } catch (Exception $e) {

        mysqli_rollback($con);
        mysqli_close($con);

        return $e->getMessage();
    }
}


// =====================================================
// OBTENER TOTAL DE PAGOS DE UN CLIENTE
// (solo la cuenta abierta, es decir liquidado = 0)
// =====================================================

function ObtenerTotalPagado($id_cliente)
{
    require("conexion.php");

    $id_cliente = intval($id_cliente);

    $stmt = mysqli_prepare($con,
        "SELECT COALESCE(SUM(monto), 0) AS total_pagado
         FROM pagos_cliente
         WHERE id_cliente = ? AND liquidado = 0");

    if (!$stmt) {
        $error = mysqli_error($con);
        mysqli_close($con);
        die("ERROR SQL: " . $error);
    }

    mysqli_stmt_bind_param($stmt, "i", $id_cliente);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $total_pagado);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($con);

    return floatval($total_pagado);
}


// =====================================================
// LISTAR HISTORIAL DE PAGOS DEL CLIENTE
// (incluye todos, liquidados o no)
// =====================================================

function ListarPagosCliente($id_cliente)
{
    require("conexion.php");

    $id_cliente = intval($id_cliente);

    $stmt = mysqli_prepare($con,
        "SELECT id_pago, id_cliente, monto, fecha_pago, liquidado
         FROM pagos_cliente
         WHERE id_cliente = ?
         ORDER BY fecha_pago ASC, id_pago ASC");

    if (!$stmt) {
        $error = mysqli_error($con);
        mysqli_close($con);
        die("ERROR SQL: " . $error);
    }

    mysqli_stmt_bind_param($stmt, "i", $id_cliente);
    mysqli_stmt_execute($stmt);

    $res = mysqli_stmt_get_result($stmt);

    $datos = array();

    while ($fila = mysqli_fetch_assoc($res)) {
        $datos[] = $fila;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return $datos;
}
?>