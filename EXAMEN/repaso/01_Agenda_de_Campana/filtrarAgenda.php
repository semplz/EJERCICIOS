<?php
require_once __DIR__ . '/datosActos.php';

function escapar($texto): string {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

// TODO 1: comprobar que la petición es GET (puedes dejarlo libre o validarlo)

// TODO 2: leer y validar provincia, partido, tipo y limite (1..10).
$provinciaSeleccionada = $_GET['provincia'] ?? 'Todas';
if ($provinciaSeleccionada !== 'Todas' && !in_array($provinciaSeleccionada, $provincias, true)) {
    $provinciaSeleccionada = 'Todas';
}

$partidoSeleccionado = $_GET['partido'] ?? 'Todos';
if ($partidoSeleccionado !== 'Todos' && !in_array($partidoSeleccionado, $partidos, true)) {
    $partidoSeleccionado = 'Todos';
}

$tipoSeleccionado = $_GET['tipo'] ?? 'Todos';
if ($tipoSeleccionado !== 'Todos' && !in_array($tipoSeleccionado, $tipos, true)) {
    $tipoSeleccionado = 'Todos';
}

$limite = (int) ($_GET['limite'] ?? 5);
if ($limite < 1 || $limite > 10) {
    $limite = 5;
}

// TODO 3: recorrer $actos y guardar todos los que cumplen LOS TRES filtros.
$filtrados = [];
foreach ($actos as $acto) {
    if ($provinciaSeleccionada !== 'Todas' && $acto['provincia'] !== $provinciaSeleccionada) {
        continue;
    }
    if ($partidoSeleccionado !== 'Todos' && $acto['partido'] !== $partidoSeleccionado) {
        continue;
    }
    if ($tipoSeleccionado !== 'Todos' && $acto['tipo'] !== $tipoSeleccionado) {
        continue;
    }
    $filtrados[] = $acto;
}

// TODO 4: calcular cantidad de coincidencias y aforo total coincidente.
$cantidadCoincidencias = count($filtrados);
$aforoTotal = 0;
foreach ($filtrados as $acto) {
    $aforoTotal += $acto['aforo'];
}

// TODO 5: mostrar solo los primeros $limite actos usando una vista externa.
$actosVisibles = array_slice($filtrados, 0, $limite);

// Cargamos la vista externa pasando todas las variables calculadas
require __DIR__ . '/vistas/agendaResultado.php';