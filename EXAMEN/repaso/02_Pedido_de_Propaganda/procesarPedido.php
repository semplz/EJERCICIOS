<?php
require_once __DIR__ . '/catalogo.php';
require_once __DIR__ . '/funciones.php';

// TODO 1: aceptar solo POST y validar partido, pack, transporte, unidades (1..8).
function comprobarMetodoPost(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        exit('Envía el formulario mediante POST.');
    }
}
comprobarMetodoPost();

$partido = $_POST['partido'] ?? '';
if (!is_string($partido) || !in_array($partido, $partidos, true)) {
    exit('Partido político no válido.');
}

$pack = $_POST['pack'] ?? '';
if (!is_string($pack) || !array_key_exists($pack, $packs)) {
    exit('Pack seleccionado no válido.');
}

$unidades = filter_var($_POST['unidades'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 8]
]);
if ($unidades === false) {
    exit('Las unidades deben ser un número entero entre 1 y 8.');
}

// TODO 2: recuperar extras[] (puede no existir), validar sus valores y eliminar duplicados.
$extrasRecibidos = $_POST['extras'] ?? [];
if (!is_array($extrasRecibidos)) {
    $extrasRecibidos = [];
}
$extrasValidados = [];
foreach ($extrasRecibidos as $extra) {
    if (is_string($extra) && array_key_exists($extra, $extras)) {
        $extrasValidados[] = $extra;
    }
}
$extrasValidados = array_unique($extrasValidados);

$transporte = $_POST['transporte'] ?? '';
if (!is_string($transporte) || !array_key_exists($transporte, $transportes)) {
    exit('Método de transporte no válido.');
}

// Validar código promocional (opcional)
$codigoInput = strtoupper(trim((string) ($_POST['codigo'] ?? '')));
$descuentoPorcentaje = 0;
if ($codigoInput !== '') {
    if (!array_key_exists($codigoInput, $codigos)) {
        exit('El código promocional no es válido.');
    }
    $descuentoPorcentaje = $codigos[$codigoInput];
}

// TODO 3: calcular precio unitario = pack + suma de extras.
function calcularPrecioUnitario(string $pack, array $extrasValidados, array $packs, array $extras): float {
    $precioPack = $packs[$pack]['precio'];
    $sumaExtras = 0;
    foreach ($extrasValidados as $extra) {
        $sumaExtras += $extras[$extra]['precio'];
    }
    return $precioPack + $sumaExtras;
}

// Llamamos a la función para obtener el precio unitario real
$precioUnitario = calcularPrecioUnitario($pack, $extrasValidados, $packs, $extras);

// TODO 4: mercancía = precio unitario * unidades; aplicar código si es válido.
//         Un código inválido NO da descuento; el transporte NO se descuenta.
$mercancia = $precioUnitario * $unidades;

$importeDescuento = round($mercancia * $descuentoPorcentaje / 100, 2);
$baseTrasDescuento = $mercancia - $importeDescuento;

// Obtenemos el coste del transporte de forma segura
$costeTransporte = $transportes[$transporte] ?? 0;

// TODO 5: calcular base con transporte, IVA 21 % y total final.
$baseConTransporte = $baseTrasDescuento + $costeTransporte;

$importeIva = round($baseConTransporte * 21 / 100, 2);

$totalFinal = $baseConTransporte + $importeIva;

// TODO 6: indicar si total final supera 500 €, y preparar desglose en la vista.
$presupuestoMaximo = 500.00;
$superaPresupuesto = ($totalFinal > $presupuestoMaximo);

// Cargamos la vista pasándole las variables
require __DIR__ . '/vistas/ticket.php';