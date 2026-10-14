<?php
require_once __DIR__ . '/repositorioPreguntas.php';
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

$asignatura = trim((string) ($_POST['asignatura'] ?? ``));
$numeroDePreguntas = filter_var($_POST['numeroDePreguntas'] ?? null, FILTER_VALIDATE_FLOAT);



// EJERCICIO 07 - PARTE A: GENERACIÓN.
// TODO 1: exige POST y valida asignatura y numeroDePreguntas (entre 1 y 5).
// TODO 2: elige al azar preguntas distintas del repositorioPreguntas de esa asignatura.
function obtenerClavesAleatorias(string $asignatura, array $repositorioPreguntas, int $numeroDePreguntas = 1 )
{
    $claves = (array) array_rand($repositorioPreguntas[$asignatura], $numeroDePreguntas);
    $numero = 0;
    foreach ($claves as $pregunta) {
        $numero++;
        echo $numero. ' - ';
        $valor = $repositorioPreguntas[$asignatura][$pregunta];
    echo htmlspecialchars($pregunta, ENT_QUOTES, 'UTF-8');
    echo '<br>';
    foreach ($valor as $indice => $textoRespuesta){
        echo '<div>';
            echo '<input type="radio"  name="pregunta_' .'" value="' . htmlspecialchars($indice, ENT_QUOTES, 'UTF-8').'>';
            echo '<label for="pregunta' . $numero . '_opt_' . $indice . '" class="label-checkbox">' . htmlspecialchars($textoRespuesta, ENT_QUOTES, 'UTF-8') . '</label>';
            echo '</div>';
        }
        echo '<br>';
    }
    }
    // TODO 3: genera un formulario HTML POST dirigido a comprobarTest.php.
    echo '<!doctype html>';
echo '<html lang="es">';
echo '<head>';
echo '<meta charset="utf-8">';
echo '<title>Datos personales</title>';
echo '</head>';
echo '<body>';
echo '<form action="comprobarTest.php" method="POST">';
echo '<h1>Mini examen</h1>';
echo '<h2>'.$asignatura.'</h2>';
echo '<p>' . obtenerClavesAleatorias($asignatura, $repositorioPreguntas, $numeroDePreguntas) . '</p>';
echo '<br>';
echo '<input type="submit">';
echo '<input type="reset">';
echo '</form>';
echo '</body>';
echo '</html>';

// TODO 4: incluye identificadores de preguntas y opciones de respuesta
//          (radios) para que el corrector pueda cotejar las respuestas.
// TODO 5: incorpora información suficiente para conocer qué asignatura
//          y qué preguntas se han mostrado, sin enviar al cliente las soluciones.

