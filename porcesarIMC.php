<?php
// EJERCICIO 04. Recibe datos desde IMC.html.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim((string)$_POST['nombre']);
    $edad= filter_var($_POST['edad'] ?? null, FILTER_VALIDATE_INT);
    $peso = filter_var($_POST['peso'] ?? null, FILTER_VALIDATE_INT);
    $altura = filter_var($_POST['altura'] ?? null, FILTER_VALIDATE_INT);
    
}

if (
    $nombre === '' ||
    mb_strlen($nombre) > 20 ||
    $peso === false ||
    $peso < 20 ||
    $peso > 500 ||
    $altura === false ||
    $altura < 50 ||
    $peso > 130 ||
    $edad === false
) {
    exit('Faltan datos o existe algún valor no válido en el formulario.');
}
$alturaMetros = pasarAMetros($altura);
function pasarAMetros($altura): float {
    $alturaMetros = $altura / 100;
    return (float) $alturaMetros;
}

function calcularIMC($peso, $alturaMetros): float {
    return (float) ($alturaMetros * $alturaMetros) / $peso ;
}

function calcularPulsacionesMaximas($edad): int {
    return 220 - (int) (0.7*$edad);
}

function mostrar($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

echo '<!doctype html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<title>Datos personales</title>';
echo '</head>';
echo '<body>';
echo '<h1>'. mostrar($nombre) .'</h1>';
echo '<p>Edad: ' . mostrar($edad) . '</p>';
echo '<p>Peso: ' . mostrar($peso) . ' kg</p>';
echo '<p>Altura: ' . mostrar($alturaMetros) . ' metros</p>';
echo '<h2>IMC</h2>';
echo mostrar(number_format(calcularIMC($peso,$altura),2));
echo '<h2>CPM</h2>';
echo calcularPulsacionesMaximas($edad);



echo '</ul>';
echo '</body>';
echo '</html>';

// TODO 1: exige POST y comprueba que los cuatro datos existen y son válidos.
// TODO 2: convierte la altura desde centímetros a metros.
// TODO 3: calcula IMC y la estimación didáctica de pulsaciones máximas.
// TODO 4: muestra los resultados con una presentación HTML legible.
// TODO 5: si algún dato falla, no realices cálculos y muestra un aviso.


