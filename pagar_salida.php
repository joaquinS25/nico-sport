<?php
require("modelo/m_mercaderia_salida.php");

$id = $_POST['id'] ?? 0;

if ($id > 0) {
    echo MarcarPago($id);
} else {
    echo "ERROR";
}