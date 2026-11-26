<?php
require_once __DIR__ . '/repositorioPreguntas.php';

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    exit('Envía el formulario mediante POST.');
}

$asignatura = trim((string) ($_POST['asignatura'] ?? ''));
$numeroDePreguntas = filter_var($_POST['numeroDePreguntas'] ?? 1, FILTER_VALIDATE_INT);

if (!$asignatura || !isset($repositorioPreguntas[$asignatura])) {
    exit('Asignatura no válida.');
}

function generarFormularioExamen(string $asignatura, array $repositorioPreguntas, int $numeroDePreguntas)
{
    $claves = array_rand($repositorioPreguntas[$asignatura], $numeroDePreguntas);
    
    if (!is_array($claves)) {
        $claves = [$claves];
    }

    $numero = 0;
    foreach ($claves as $pregunta) {
        // Campo oculto para enviar qué preguntas han salido
        echo '<input type="hidden" name="preguntas[]" value="' . htmlspecialchars($pregunta, ENT_QUOTES, 'UTF-8') . '">';
        
        $numero++;
        echo '<p><strong>' . $numero . ' - ' . htmlspecialchars($pregunta, ENT_QUOTES, 'UTF-8') . '</strong></p>';
        
        $valor = $repositorioPreguntas[$asignatura][$pregunta];
        foreach ($valor as $indice => $textoRespuesta) {
            $idInput = 'pregunta_' . $numero . '_opt_' . $indice;
            echo '<div>';
            echo '<input type="radio" id="' . $idInput . '" name="respuestas[' . htmlspecialchars($pregunta, ENT_QUOTES, 'UTF-8') . ']" value="' . htmlspecialchars($textoRespuesta, ENT_QUOTES, 'UTF-8') . '">';
            echo '<label for="' . $idInput . '">' . htmlspecialchars($textoRespuesta, ENT_QUOTES, 'UTF-8') . '</label>';
            echo '</div>';
        }
        echo '<br>';
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Mini Examen</title>
</head>
<body>
    <form action="comprobarTest.php" method="POST">
        <h1>Mini examen</h1>
        <h2><?php echo htmlspecialchars($asignatura, ENT_QUOTES, 'UTF-8'); ?></h2>
        
        <input type="hidden" name="asignatura" value="<?php echo htmlspecialchars($asignatura, ENT_QUOTES, 'UTF-8'); ?>">
        
        <?php generarFormularioExamen($asignatura, $repositorioPreguntas, $numeroDePreguntas); ?>
        
        <br>
        <input type="submit" value="Enviar">
        <input type="reset" value="Reiniciar">
    </form>
</body>
</html>