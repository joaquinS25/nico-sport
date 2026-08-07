<?php

// =====================================================
// LISTAR SALIDA DE MERCADERÍA
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
// REGISTRAR SALIDA
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

    $sql = "INSERT INTO salida_mercaderia
            (
                id_cliente,
                cantidad,
                producto,
                precio,
                fecha_registro,
                pago
            )
            VALUES
            (
                '$id_cliente',
                '$cantidad',
                '$producto',
                '$precio',
                '$fecha_registro',
                'NO'
            )";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("ERROR SQL: " . mysqli_error($con));
    }

    mysqli_close($con);

    return "SI";
}


// =====================================================
// REGISTRAR PAGO DEL CLIENTE
// =====================================================

function RegistrarPagoCliente($id_cliente, $monto, $fecha_pago)
{
    require("conexion.php");

    $id_cliente = intval($id_cliente);
    $monto = floatval($monto);
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

    $sql = "INSERT INTO pagos_cliente
            (id_cliente, monto, fecha_pago)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt) {
        $error = mysqli_error($con);
        mysqli_close($con);

        return "ERROR_SQL_PREPARE: " . $error;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ids",
        $id_cliente,
        $monto,
        $fecha_pago
    );

    if (!mysqli_stmt_execute($stmt)) {

        $error = mysqli_stmt_error($stmt);

        mysqli_stmt_close($stmt);
        mysqli_close($con);

        return "ERROR_SQL_EXECUTE: " . $error;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($con);

    return "SI";
}

// =====================================================
// OBTENER TOTAL DE PAGOS DE UN CLIENTE
// =====================================================

function ObtenerTotalPagado($id_cliente)
{
    require("conexion.php");

    $sql = "SELECT 
                COALESCE(SUM(monto), 0) AS total_pagado
            FROM pagos_cliente
            WHERE id_cliente = '$id_cliente'";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("ERROR SQL: " . mysqli_error($con));
    }

    $fila = mysqli_fetch_assoc($res);

    mysqli_close($con);

    return floatval($fila['total_pagado']);
}


// =====================================================
// LISTAR HISTORIAL DE PAGOS DEL CLIENTE
// =====================================================

function ListarPagosCliente($id_cliente)
{
    require("conexion.php");

    $sql = "SELECT
                id_pago,
                id_cliente,
                monto,
                fecha_pago
            FROM pagos_cliente
            WHERE id_cliente = '$id_cliente'
            ORDER BY fecha_pago ASC, id_pago ASC";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("ERROR SQL: " . mysqli_error($con));
    }

    $datos = array();

    while ($fila = mysqli_fetch_assoc($res)) {
        $datos[] = $fila;
    }

    mysqli_close($con);

    return $datos;
}
?>