<?php
require_once __DIR__ . '/repositorioPreguntas.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    exit('Envía el formulario mediante POST.');
}

$asignatura = $_POST['asignatura'] ?? '';
$respuestasUsuario = $_POST['respuestas'] ?? [];
$totalPreguntasEnviadas = intval($_POST['totalPreguntas'] ?? 0);

if (!isset($repositorioRespuestas[$asignatura])) {
    exit('Asignatura no válida.');
}

$aciertos = 0;
$fallos = 0;
$blancos = 0;

$soluciones = $repositorioRespuestas[$asignatura];

foreach ($respuestasUsuario as $pregunta => $respuestaUsuario) {
    if (isset($soluciones[$pregunta])) {
        if ($respuestaUsuario === '') {
            $blancos++;
        } elseif ($respuestaUsuario === $soluciones[$pregunta]) {
            $aciertos++;
        } else {
            $fallos++;
        }
    }
}

$total = $totalPreguntasEnviadas > 0 ? $totalPreguntasEnviadas : count($soluciones);
$nota = $total > 0 ? ($aciertos / $total) * 10 : 0;
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Resultado</title>
</head>
<body>
    <h1>Resultado del test</h1>
    <p>Asignatura: <?php echo htmlspecialchars($asignatura, ENT_QUOTES, 'UTF-8'); ?></p>
    <p>Aciertos: <?php echo $aciertos; ?></p>
    <p>Fallos: <?php echo $fallos; ?></p>
    <p>En blanco: <?php echo $blancos; ?></p>
    <p><strong>Nota: <?php echo number_format($nota, 2); ?> / 10</strong></p>

    <a href="generadorDeTests.html">Volver</a>
</body>
</html>