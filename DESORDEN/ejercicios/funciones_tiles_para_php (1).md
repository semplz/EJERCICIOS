<?php
/**
 * Librería de Funciones Útiles para Formularios y Ejercicios (PHP UD1)
 * Nivel introductorio enfocado en prácticas de clase.
 */

/**
 * 1. Comprueba si la petición es de tipo POST
 */
function verificarPost() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Este archivo requiere una petición POST.');
    }
}

/**
 * 2. Limpia y sanitiza texto para evitar espacios sobrantes y XSS
 */
function limpiarTexto($texto) {
    $textoLimpio = trim((string)($texto ?? ''));
    return htmlspecialchars($textoLimpio, ENT_QUOTES, 'UTF-8');
}

/**
 * 3. Valida un número entero dentro de un rango opcional
 */
function validarEntero($valor, $min = null, $max = null) {
    $opciones = [];
    if ($min !== null) $opciones['min_range'] = $min;
    if ($max !== null) $opciones['max_range'] = $max;
    
    $args = empty($opciones) ? [] : ['options' => $opciones];
    
    $resultado = filter_var($valor, FILTER_VALIDATE_INT, $args);
    return $resultado; // Devuelve false si no es válido
}

/**
 * 4. Valida un número decimal/flotante dentro de un rango opcional
 */
function validarFlotante($valor, $min = null, $max = null) {
    $resultado = filter_var($valor, FILTER_VALIDATE_FLOAT);
    if ($resultado === false) return false;
    
    if ($min !== null && $resultado < $min) return false;
    if ($max !== null && $resultado > $max) return false;
    
    return $resultado;
}

/**
 * 5. Valida si una opción enviada (Select o Radio) está en la lista permitida
 */
function validarOpcionSeleccionada($valor, array $permitidas) {
    $limpio = trim((string)($valor ?? ''));
    if (array_key_exists($limpio, $permitidas) || in_array($limpio, $permitidas, true)) {
        return $limpio;
    }
    return false;
}

/**
 * 6. Valida un array de casillas de verificación (Checkbox)
 */
function validarCheckboxArray($seleccion, array $validas) {
    if (!is_array($seleccion)) {
        return [];
    }
    $filtradas = [];
    foreach ($seleccion as $item) {
        if (is_string($item) && in_array($item, $validas, true)) {
            $filtradas[] = $item;
        }
    }
    return $filtradas;
}

/**
 * 7. Calcula la diferencia de horas entre dos marcas temporales (strtotime)
 */
function calcularHoras($horaInicio, $horaFin) {
    $inicio = strtotime($horaInicio);
    $fin = strtotime($horaFin);
    
    if ($inicio === false || $fin === false || $fin < $inicio) {
        return 0;
    }
    
    return ($fin - $inicio) / 3600;
}

/**
 * 8. Formatea un precio o número a dos decimales con formato legible
 */
function formatearPrecio($numero) {
    $redondeado = round((float)$numero, 2);
    return number_format($redondeado, 2, ',', '.');
}

/**
 * 9. Función de selección aleatoria (Útil para tests automáticos con array_rand)
 */
function obtenerClavesAleatorias(array $repositorio, int $cantidad = 1) {
    if (count($repositorio) === 0) {
        return [];
    }
    // Asegurar que no pedimos más elementos de los que hay
    $cantidad = min($cantidad, count($repositorio));
    
    $claves = array_rand($repositorio, $cantidad);
    
    // array_rand devuelve un escalar si $cantidad es 1, lo convertimos a array para iterar unificado
    return is_array($claves) ? $claves : [$claves];
}
?>