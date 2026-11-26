<?php
/**
 * Librería de Funciones Útiles para el Procesamiento y Validación de Formularios en PHP
 * Basado en la Unidad Didáctica 01: Introducción a PHP
 */

/**
 * Comprueba si la solicitud HTTP es de tipo POST. 
 * Si no lo es, establece un código de error 405 y detiene la ejecución.
 */
function comprobarMetodoPost() {
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
        http_response_code(405);
        exit('Error 405: Este archivo requiere el envío de datos mediante el método POST.');
    }
}

/**
 * Limpia y sanea una cadena de texto recibida de un formulario.
 * Elimina espacios en blanco iniciales/finales y escapa caracteres especiales HTML.
 * 
 * @param mixed $dato
 * @return string
 */
function limpiarTexto($dato) {
    $texto = trim((string) ($dato ?? ''));
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Valida si un valor es un número entero dentro de un rango opcional.
 * 
 * @param mixed $valor
 * @param int|null $min
 * @param int|null $max
 * @return int|false Devuelve el entero validado o false si no es válido.
 */
function validarEntero($valor, $min = null, $max = null) {
    $opciones = [];
    if ($min !== null && $max !== null) {
        $opciones = ['options' => ['min_range' => $min, 'max_range' => $max]];
    }
    return filter_var($valor, FILTER_VALIDATE_INT, $opciones);
}

/**
 * Valida si un valor es un número flotante (decimal) dentro de un rango opcional.
 * 
 * @param mixed $valor
 * @param float|null $min
 * @param float|null $max
 * @return float|false
 */
function validarFloat($valor, $min = null, $max = null) {
    $val = filter_var($valor, FILTER_VALIDATE_FLOAT);
    if ($val === false) {
        return false;
    }
    if ($min !== null && $val < $min) return false;
    if ($max !== null && $val > $max) return false;
    return $val;
}

/**
 * Valida si un correo electrónico tiene un formato correcto.
 * 
 * @param string $email
 * @return string|false
 */
function validarEmail($email) {
    $limpio = filter_var(trim($email ?? ''), FILTER_SANITIZE_EMAIL);
    return filter_var($limpio, FILTER_VALIDATE_EMAIL);
}

/**
 * Valida que una opción seleccionada (radio o select) pertenezca a un conjunto permitido.
 * 
 * @param mixed $opcionRecibida
 * @param array $opcionesValidas Array asociativo o indexado con los valores permitidos.
 * @return bool
 */
function validarOpcionSeleccionada($opcionRecibida, array $opcionesValidas) {
    if (!is_string($opcionRecibida) && !is_numeric($opcionRecibida)) {
        return false;
    }
    // Si es array asociativo, comprobamos las claves; si es indexado, los valores
    if (array_keys($opcionesValidas) !== range(0, count($opcionesValidas) - 1)) {
        return array_key_exists($opcionRecibida, $opcionesValidas);
    } else {
        return in_array($opcionRecibida, $opcionesValidas, true);
    }
}

/**
 * Valida un array de casillas de verificación (checkboxes múltiples, ej: aficiones, módulos).
 * 
 * @param mixed $seleccionRecibida
 * @param array $valoresValidos
 * @return array Devuelve el array limpio y validado o lanza un error si hay elementos no válidos.
 */
function validarArrayCheckboxes($seleccionRecibida, array $valoresValidos) {
    $seleccion = $seleccionRecibida ?? [];
    if (!is_array($seleccion)) {
        return [];
    }
    
    $validados = [];
    foreach ($seleccion as $item) {
        if (is_string($item) && in_array($item, $valoresValidos, true)) {
            $validados[] = $item;
        }
    }
    return $validados;
}

/**
 * Calcula las horas transcurridas entre dos cadenas de hora (formato HH:MM del mismo día).
 * 
 * @param string $horaInicio Ej: '08:30'
 * @param string $horaFin Ej: '10:00'
 * @return float|false
 */
function calcularDuracionHoras($horaInicio, $horaFin) {
    $inicio = strtotime($horaInicio);
    $fin = strtotime($horaFin);
    
    if ($inicio === false || $fin === false || $fin <= $inicio) {
        return false;
    }
    
    return ($fin - $inicio) / 3600;
}

/**
 * Formatea un número decimal como precio con dos decimales y separadores personalizados.
 * 
 * @param float $precio
 * @return string
 */
function formatearPrecioEuros($precio) {
    $redondeado = round((float)$precio, 2);
    return number_format($redondeado, 2, ',', '.') . ' €';
}
?>