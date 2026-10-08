<?php
require_once 'componentes.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

$modelo = trim((string) ($_POST['Modelo'] ?? ''));
$motor = trim((string) ($_POST['Motor'] ?? ''));
$color = trim((string) ($_POST['Color'] ?? ''));
$llantas = trim((string) ($_POST['Llantas'] ?? ''));
$equipamiento = trim((string) ($_POST['Equipamiento'] ?? ''));

if ($modelo === '' || $motor === '' || $color === '' || $llantas === '' || $equipamiento === '') {
    exit('Debes completar todas las opciones obligatorias.');
}

$accesoriosSeleccionados = $_POST['Accesorios'] ?? [];
if (!is_array($accesoriosSeleccionados)) {
    $accesoriosSeleccionados = [];
}

$cantidad = filter_var($_POST['cantidad'] ?? 1, FILTER_VALIDATE_INT);
if ($cantidad === false || $cantidad < 1 || $cantidad > 5) {
    $cantidad = 1;
}

$codigoDescuento = trim((string) ($_POST['codigo_descuento'] ?? ''));

$precioUnitario = 0.0;
$precioUnitario += $componentes['Modelo'][$modelo] ?? 0.0;
$precioUnitario += $componentes['Motor'][$motor] ?? 0.0;
$precioUnitario += $componentes['Color'][$color] ?? 0.0;
$precioUnitario += $componentes['Llantas'][$llantas] ?? 0.0;
$precioUnitario += $componentes['Equipamiento'][$equipamiento] ?? 0.0;

foreach ($accesoriosSeleccionados as $acc) {
    $precioUnitario += $componentes['Accesorios'][$acc] ?? 0.0;
}

$subtotalSinDescuento = $precioUnitario * $cantidad;

$importeDescuento = 0.0;
$mensajeDescuento = '';

if ($codigoDescuento !== '') {
    if (isset($codigosDescuento[$codigoDescuento])) {
        $porcentaje = $codigosDescuento[$codigoDescuento];
        $importeDescuento = $subtotalSinDescuento * ($porcentaje / 100);
        $mensajeDescuento = "Código aplicado: $codigoDescuento ($porcentaje%)";
    } else {
        $mensajeDescuento = "El código de descuento '$codigoDescuento' es inválido.";
    }
}

$baseImponible = $subtotalSinDescuento - $importeDescuento;
if ($baseImponible < 0) {
    $baseImponible = 0.0;
}

$iva = $baseImponible * 0.21;
$totalPagar = $baseImponible + $iva;