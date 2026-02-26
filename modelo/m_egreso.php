<?php

function RegistrarEgreso($cantidad, $descripcion, $precio, $id_medio_pago, $id_usuario)
{
    require("conexion.php");

    $fecha = date("Y-m-d");

    $precio_efectivo = 0;
    $precio_yape = 0;

    // 7 = efectivo | 6 = yape (ajusta si tus IDs son diferentes)
    if($id_medio_pago == 7){
        $precio_efectivo = $precio;
    }

    if($id_medio_pago == 6){
        $precio_yape = $precio;
    }

    $sql = "INSERT INTO egresos
            (fecha, cantidad, descripcion, precio, precio_efectivo, precio_yape, id_medio_pago, id_usuario)
            VALUES
            ('$fecha','$cantidad','$descripcion','$precio','$precio_efectivo','$precio_yape','$id_medio_pago','$id_usuario')";

    $res = mysqli_query($con, $sql);

    mysqli_close($con);

    return $res ? "SI" : "NO";
}
function ListarEgresos()
{
    require("conexion.php");

    $sql = "SELECT e.*, 
                   mp.nom_medio_pago, 
                   u.nom_usuario, 
                   u.ape_usuario
            FROM egresos e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN medios_pago mp ON e.id_medio_pago = mp.id_medio_pago
            ORDER BY e.fecha DESC";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("Error SQL: " . mysqli_error($con));
    }

    $datos = [];

    while ($fila = mysqli_fetch_assoc($res)) {
        $datos[] = $fila;
    }

    mysqli_close($con);

    return $datos;
}
function ListarEgresosPorFecha($fecha)
{
    require("conexion.php");

    $sql = "SELECT e.*, 
                   mp.nom_medio_pago, 
                   u.nom_usuario, 
                   u.ape_usuario
            FROM egresos e
            INNER JOIN usuario u ON e.id_usuario = u.id_usuario
            INNER JOIN medios_pago mp ON e.id_medio_pago = mp.id_medio_pago
            WHERE DATE(e.fecha) = '$fecha'
            ORDER BY e.fecha DESC";

    $res = mysqli_query($con, $sql);

    if (!$res) {
        die("Error SQL: " . mysqli_error($con));
    }

    $datos = [];

    while ($fila = mysqli_fetch_assoc($res)) {
        $datos[] = $fila;
    }

    mysqli_close($con);

    return $datos;
}

?>