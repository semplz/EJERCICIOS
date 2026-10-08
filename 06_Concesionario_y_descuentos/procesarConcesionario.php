<?php
require_once __DIR__ . '/componentes.php'; // Datos iniciales de opciones, precios y descuentos.

// EJERCICIO 06.
// TODO 1: comprueba el método POST y valida las cinco opciones obligatorias.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    exit('Emvia el formulario mediante POST.');
    }

    $modelo = trim((string) ($_POST['Modelo'] ?? ''));
    $motor = trim((string) ($_POST['Motor'] ?? ''));
    $color = trim((string) ($_POST['Color'] ?? ''));
    $llantas = trim((string) ($_POST['Llantas'] ?? ''));
    $equipamiento = trim((string) ($_POST['Equipamiento'] ?? ''));
    $cantidad = filter_var($_POST['cantidad'] ?? 1, FILTER_VALIDATE_INT);
    $accesorios = $_POST['Accesorios'] ?? [];

    if ($modelo === '') {
        exit('Debes indicar el modelo para completar el formulario');
    }
    if ($motor === '') {
        exit('Debes indicar el motor para completar el formulario');
    }
    if ($color === '') {
        exit('Debes indicar el color para completar el formulario');
    }
    if ($llantas === '') {
        exit('Debes indicar el llantas para completar el formulario');
    }
    if ($equipamiento === '') {
        exit('Debes indicar el equipamiento para completar el formulario');
    }
    // TODO 2: recoge los accesorios seleccionados (pueden ser cero) y la cantidad (1–5).
// TODO 3: calcula el precio unitario SIN IVA a partir de los precios proporcionados.
// TODO 4: multiplica por el número de vehículos y aplica el descuento, si es válido.
// TODO 5: calcula un IVA del 21 % sobre la base una vez descontada la rebaja.
// TODO 6: genera un resumen con opciones, importes, descuentos, IVA y total.
// Si el código de descuento no existe, indica que es inválido y no apliques rebaja.

echo 'Pendiente de implementar el ejercicio 06.';
