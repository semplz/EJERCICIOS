<?php
require_once __DIR__ . '/datosPartidos.php';
// Definimos la función directamente aquí
function escapar($texto): string {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

// TODO 1: aceptar POST y validar censo entero entre 1 y 100000.
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

$censo = filter_var($_POST['censo'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 100000]
]);

if ($censo === false) {
    exit('El censo debe ser un número entero válido entre 1 y 100.000.');
}

// TODO 2: validar que votos[] contiene exactamente las claves de $partidos,
//         y que todos los votos, blancos y nulos son enteros >= 0.
$votosRecibidos = $_POST['votos'] ?? [];
if (!is_array($votosRecibidos)) {
    exit('El formato de los votos no es válido.');
}

$clavesRecibidas = array_keys($votosRecibidos);
sort($clavesRecibidas);
$partidosOrdenados = $partidos;
sort($partidosOrdenados);

if ($clavesRecibidas !== $partidosOrdenados) {
    exit('Los partidos enviados no coinciden exactamente con el catálogo oficial.');
}

$votosValidados = [];
foreach ($partidos as $partido) {
    $cantidad = filter_var($votosRecibidos[$partido] ?? null, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 0]
    ]);

    if ($cantidad === false) {
        exit("Los votos para el partido $partido deben ser un número entero mayor o igual a 0.");
    }

    $votosValidados[$partido] = $cantidad;
}

// Validar votos en blanco
$blancosInput = trim($_POST['blancos'] ?? '0');
if ($blancosInput === '') { $blancosInput = '0'; }
$votosBlanco = filter_var($blancosInput, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($votosBlanco === false) {
    exit('Los votos en blanco no son válidos.');
}

// Validar votos nulos
$nulosInput = trim($_POST['nulos'] ?? '0');
if ($nulosInput === '') { $nulosInput = '0'; }
$votosNulo = filter_var($nulosInput, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
if ($votosNulo === false) {
    exit('Los votos nulos no son válidos.');
}

// TODO 3: votos a candidaturas, votos válidos, emitidos, abstención y participación.
$votosCandidaturas = array_sum($votosValidados);
$votosValidos = $votosCandidaturas + $votosBlanco;
$votosEmitidos = $votosValidos + $votosNulo;
$abstencion = $censo - $votosEmitidos;
$porcentajeParticipacion = ($censo > 0) ? round(($votosEmitidos / $censo) * 100, 2) : 0;

// TODO 4: rechazar votos emitidos > censo y recuentos de 0 emitidos.
if ($votosEmitidos > $censo) {
    exit('Error: Los votos emitidos superan el censo.');
}
if ($votosEmitidos === 0) {
    exit('Error: No hay votos emitidos.');
}

// TODO 5: calcular porcentajes sobre VOTOS VÁLIDOS, ordenar y detectar empate.
arsort($votosValidados);

$porcentajes = [];
foreach ($votosValidados as $partido => $votos) {
    $porcentajes[$partido] = ($votosValidos > 0) ? round(($votos / $votosValidos) * 100, 2) : 0;
}

$valores = array_values($votosValidados);
$hayEmpatePrimerPuesto = (count($valores) >= 2 && $valores[0] === $valores[1]);

// TODO 6: contar cuántos partidos alcanzan el umbral del 5 %.
$partidosSuperanUmbral = 0;
foreach ($porcentajes as $porcentaje) {
    if ($porcentaje >= $umbralPorcentaje) {
        $partidosSuperanUmbral++;
    }
}

// TODO 7: mostrar tabla HTML mediante vistas/resultados.php.
require __DIR__ . '/vistas/resultados.php';