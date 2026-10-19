<?php
/**
 * LIBRERÍA / CHULETA DE FUNCIONES PARA EL EXAMEN DE PHP
 * Nivel: Ciclo DAW (Práctico, directo y seguro)
 */

// ==========================================
// 1. CONTROL DE ACCESO (Peticiones HTTP)
// ==========================================

/**
 * Comprueba obligatoriamente si los datos se han enviado por POST.
 * Qué cambiar: El mensaje de texto si el profesor pide otro error.
 */
function comprobarMetodoPost(): void {
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        http_response_code(405);
        exit('Envía el formulario mediante POST[cite: 34].');
    }
}


// ==========================================
// 2. FUNCIONES DE LIMPIEZA Y FORMATO DE TEXTO
// ==========================================

/**
 * Escapa caracteres especiales para evitar ataques XSS al pintar en HTML[cite: 33].
 * Qué cambiar: Nada, úsala siempre que hagas un echo con datos del usuario[cite: 33].
 */
function limpiarHtml($texto): string {
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Pone la primera letra en mayúscula y el resto en minúscula (útil para nombres).
 * Qué cambiar: Puedes usar ucwords() si quieres que sea la primera letra de cada palabra.
 */
function formatearNombrePropio($texto): string {
    $texto = (string) $texto;
    $texto = mb_strtolower($texto, 'UTF-8');
    return ucfirst($texto);
}

/**
 * Formatea un número como precio en euros (2 decimales, comas y puntos)[cite: 33].
 * Qué cambiar: El símbolo de la moneda si te piden dólares u otra cosa.
 */
function formatearEuros($importe): string {
    return number_format((float)$importe, 2, ',', '.') . ' €';
}


// ==========================================
// 3. VALIDACIÓN DE DATOS NUMÉRICOS
// ==========================================

/**
 * Valida un número entero asegurándose de que está dentro de un rango[cite: 41, 46].
 * Qué cambiar: Los valores de $min y $max según el enunciado (ej. cantidad de 1 a 5, edad de 18 a 100).
 */
function validarEnteroConRango($valor, int $min, int $max) {
    $resultado = filter_var($valor, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => $min, 'max_range' => $max]
    ]);
    return $resultado; // Devuelve el entero válido o false si falla[cite: 41, 46]
}

/**
 * Valida un número con decimales (flotante) y opcionalmente un rango[cite: 41].
 * Qué cambiar: Los límites de $min y $max (ej. peso entre 20 y 500)[cite: 41].
 */
function validarFlotanteConRango($valor, float $min = 0.01, float $max = 10000.0) {
    $resultado = filter_var($valor, FILTER_VALIDATE_FLOAT);
    if ($resultado === false || $resultado < $min || $resultado > $max) {
        return false;
    }
    return $resultado;
}


// ==========================================
// 4. VALIDACIÓN DE CORREOS Y CADENAS DE TEXTO
// ==========================================

/**
 * Valida el formato estándar de un correo electrónico[cite: 40].
 * Qué cambiar: Nada, utiliza el filtro interno nativo de PHP.
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Valida una cadena de texto controlando espacios y longitud máxima/mínima[cite: 42].
 * Qué cambiar: La longitud máxima (ej: 20 o 50 caracteres) según lo que pida el campo[cite: 42].
 */
function validarTextoLongitud(string $texto, int $min = 1, int $max = 50): string {
    $limpio = trim($texto);
    if (mb_strlen($limpio, 'UTF-8') < $min || mb_strlen($limpio, 'UTF-8') > $max) {
        return ''; // Cadena vacía indica error
    }
    return $limpio;
}


// ==========================================
// 5. VALIDACIÓN DE LISTAS, SELECTS Y RADIO BUTTONS
// ==========================================

/**
 * Valida que una opción seleccionada exista en un array asociativo (ej: repositorio o precios)[cite: 23, 34].
 * Qué cambiar: El array de opciones válidas.
 */
function validarOpcionAsociativa($opcion, array $arrayValido): bool {
    return is_string($opcion) && array_key_exists($opcion, $arrayValido);
}

/**
 * Valida que un valor pertenezca a una lista indexada simple (ej: sexos o estados civiles)[cite: 23].
 * Qué cambiar: El array con los valores permitidos.
 */
function validarOpcionSimple($opcion, array $listaPermitida): bool {
    return in_array($opcion, $listaPermitida, true);
}


// ==========================================
// 6. VALIDACIÓN DE CHECKBOXES MÚLTIPLES (ARRAYS)
// ==========================================

/**
 * Valida de forma segura un array de checkboxes (aficiones, módulos, etc.)[cite: 34, 46].
 * Qué cambiar: El array $permitidos con las opciones legales del sistema.
 */
function validarCheckboxesMultiples($recibido, array $permitidos): array {
    if (!is_array($recibido)) {
        return [];
    }
    
    $validados = [];
    foreach ($recibido as $item) {
        if (is_string($item) && in_array($item, $permitidos, true)) {
            $validados[] = $item;
        }
    }
    return array_unique($validados); // Evita duplicados[cite: 34]
}


// ==========================================
// 7. VALIDACIÓN DE FECHAS
// ==========================================

/**
 * Comprueba si una fecha es real y correcta usando checkdate[cite: 44].
 * Qué cambiar: Nada, recibe el día, mes y año numéricos.
 */
function validarFechaReal(int $dia, int $mes, int $anio): bool {
    return checkdate($mes, $dia, $anio);
}


// ==========================================
// 8. SELECCIÓN ALEATORIA DE UN ARRAY (Tests)
// ==========================================

/**
 * Elige claves aleatorias de un array (como preguntas de un test)[cite: 23].
 * Forzar con (array) previene errores si se solicita un solo elemento[cite: 23, 47].
 * Qué cambiar: El array de origen y la cantidad deseada.
 */
function obtenerElementosAleatorios(array $repositorio, int $cantidad): array {
    return (array) array_rand($repositorio, $cantidad);
}


// ==========================================
// 9. GESTIÓN Y SUBIDA SEGURA DE ARCHIVOS
// ==========================================

/**
 * Procesa la subida de una imagen (JPEG/PNG) controlando tamaño y tipos MIME[cite: 45].
 * Qué cambiar: El límite de tamaño (aquí 2MB) o las extensiones admitidas[cite: 45].
 */
function procesarSubidaFichero(array $fichero): string {
    if ($fichero['error'] !== UPLOAD_ERR_OK) {
        exit('Error en la subida del archivo[cite: 45].');
    }
    
    // Límite de 2 MB (2 * 1024 * 1024 bytes)[cite: 45]
    if ($fichero['size'] > 2097152) {
        exit('El archivo supera los 2 MB permitidos[cite: 45].');
    }
    
    // Comprobación real del tipo MIME[cite: 45]
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($fichero['tmp_name']);
    $extensionesValidas = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
    
    if (!isset($extensionesValidas[$mime])) {
        exit('Solo se permiten imágenes en formato JPEG o PNG[cite: 45].');
    }
    
    // Generar nombre seguro aleatorio para evitar colisiones[cite: 45]
    $nombreUnico = bin2hex(random_bytes(16)) . '.' . $extensionesValidas[$mime];
    $directorioDestino = __DIR__ . '/uploads/';
    
    if (!is_dir($directorioDestino)) {
        mkdir($directorioDestino, 0755, true);
    }
    
    $rutaFinal = $directorioDestino . $nombreUnico;
    
    if (!move_uploaded_file($fichero['tmp_name'], $rutaFinal)) {
        exit('No se pudo guardar el archivo en el servidor[cite: 45].');
    }
    
    return $nombreUnico;
}
?>