<?php
require_once __DIR__ . '/datosEscenarios.php';
require_once __DIR__ . '/funciones.php';

// TODO 1: exigir POST, validar escenario y socios[] (array de 1 a 3 partidos).
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

$escenario = $_POST['escenario'] ?? '';
if (!is_string($escenario) || !array_key_exists($escenario, $escenarios)) {
    exit('Escenario no válido.');
}

$sociosRecibidos = $_POST['socios'] ?? [];
if (!is_array($sociosRecibidos)) {
    $sociosRecibidos = [];
}

// TODO 2: rechazar socios repetidos y nombres ajenos a la lista del escenario.
if (count($sociosRecibidos) !== count(array_unique($sociosRecibidos))) {
    exit('Error: Has seleccionado socios repetidos.');
}

$partidosPermitidos = array_keys($escenarios[$escenario]['partidos']);
$sociosValidados = [];

foreach ($sociosRecibidos as $socio) {
    if (!is_string($socio) || !in_array($socio, $partidosPermitidos, true)) {
        exit('Error: El partido seleccionado no pertenece a este escenario.');
    }
    $sociosValidados[] = $socio;
}

$totalSocios = count($sociosValidados);
if ($totalSocios < 1 || $totalSocios > 3) {
    exit('Error: Debes seleccionar entre 1 y 3 partidos.');
}

// TODO 3: sumar escaños y calcular mayoría absoluta (mitad + 1).
$escanosSocios = 0;
foreach ($sociosValidados as $socio) {
    $escanosSocios += $escenarios[$escenario]['partidos'][$socio];
}

$totalEscanosEscenario = $escenarios[$escenario]['escanos'];
$mayoriaAbsoluta = intdiv($totalEscanosEscenario, 2) + 1;

// TODO 4: indicar mayoría sí/no, y cuántos escaños sobran o faltan.
$tieneMayoria = ($escanosSocios >= $mayoriaAbsoluta);
$diferencia = $escanosSocios - $mayoriaAbsoluta;

if ($tieneMayoria) {
    $textoMayoria = "Sí";
    $diferenciaTexto = "Sobran " . $diferencia . " escaños sobre la mayoría absoluta.";
} else {
    $textoMayoria = "No";
    $diferenciaTexto = "Faltan " . abs($diferencia) . " escaños para alcanzar la mayoría absoluta.";
}

// TODO 5: para cada partido que NO forme parte del pacto, calcular escaños si se uniera.
$alternativas = [];
$todosLosPartidos = $escenarios[$escenario]['partidos'];

foreach ($todosLosPartidos as $partido => $escanosPartido) {
    if (!in_array($partido, $sociosValidados, true)) {
        $nuevosEscanos = $escanosSocios + $escanosPartido;
        
        $alternativas[$partido] = [
            'escanos' => $nuevosEscanos,
            'alcanzaMayoria' => ($nuevosEscanos >= $mayoriaAbsoluta)
        ];
    }
}

// TODO 6: indicar qué partido fuera del pacto permitiría llegar a la mayoría con la menor aportación.
$socioOptimo = null;
$minEscanosAportados = PHP_INT_MAX;

if ($tieneMayoria) {
    $mensajeSocioOptimo = "El pacto ya cuenta con mayoría absoluta. No se necesita ningún socio adicional.";
} else {
    foreach ($alternativas as $partido => $datos) {
        if ($datos['alcanzaMayoria']) {
            $escanosPartido = $escenarios[$escenario]['partidos'][$partido];
            if ($escanosPartido < $minEscanosAportados) {
                $minEscanosAportados = $escanosPartido;
                $socioOptimo = $partido;
            }
        }
    }

    if ($socioOptimo !== null) {
        $mensajeSocioOptimo = "El socio óptimo es **$socioOptimo** aportando la menor cantidad de escaños ($minEscanosAportados).";
    } else {
        $mensajeSocioOptimo = "Ningún partido por sí solo permite alcanzar la mayoría absoluta.";
    }
}

// TODO 7: mostrar el informe cargando la vista al final.
require __DIR__ . '/vistas/informe.php';