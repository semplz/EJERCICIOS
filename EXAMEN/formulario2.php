<?php
function validarRequestPost(){
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Este archivo requiere POST.');
}
}
function validarRequestGet() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        http_response_code(405);
        exit('Este archivo requiere GET.');
    }
}


function validarPost($array, $clave) {
    echo "Comprobando la clave '$clave'...\n";


    // Si la clave no existe en el array, informamos y salimos
    if (!isset($array[$clave])) {
        echo "❌ Error: La clave '$clave' no llegó en el post o no existe.\n";
        return false;
    }


    // Si existe pero está vacío (ignorando espacios), informamos y salimos
    if (empty(trim($array[$clave]))) {
        echo "⚠️ Advertencia: La clave '$clave' existe, pero llegó vacía.\n";
        return false;
    }


    // Si pasó todas las comprobaciones, mostramos mensaje de éxito
    echo "✅ Éxito: El dato '$clave' llegó correctamente.\n";
    return true;
}


function validarEntero(string $campo, int $min, int $max): int|false
{
    return filter_var(
        $_POST[$campo] ?? null,
        FILTER_VALIDATE_INT,
        [
            'options' => [
                'min_range' => $min,
                'max_range' => $max
            ]
        ]
    );
}






function validarDecimal(string $campo, float $min, float $max): float|false
{
    $valor = filter_var(
        $_POST[$campo] ?? null,
        FILTER_VALIDATE_FLOAT
    );


    if ($valor !== false && $valor >= $min && $valor <= $max) {
        return $valor;
    }


    return false;
}


function imprimirCabecera(string $titulo): void
{
    echo '<!doctype html>';
    echo '<html lang="es">';
    echo '<head>';
    echo '<meta charset="utf-8">';
    echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    echo '<title>' . htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') . '</title>';
    echo '</head>';
    echo '<body>';
}


function imprimirPie(): void
{
    echo '</body>';
    echo '</html>';
}


function modoOscuro(): void {
    echo "<style>
    * {
        color: white;
        background-color: rgb(49, 49, 49);
    }
    </style>";
}
function mostrarPost(){
    print_r($_POST);
};
function mostrarGet(){
    print_r($_GET);
};
function validarText($postGet , $name) {
    $valor = trim((string)($postGet[$name] ?? ''));
    if ($valor === "") {
        echo "El valor= " . $name . " No se esta recogiendo bien revisa el name=\"\" del html ";
    }
    return $valor;
}
function validarTextOpcional($postGet , $name) {
    $valor = trim((string)($postGet[$name] ?? ''));
    return $valor;
}


function validaNumeroIntMinMax($postGet,$name, $minimo, $maximo) {
    $resultado = filter_var($postGet[$name] ?? $minimo, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => $minimo, // Corregido: min_range con guion bajo
            'max_range' => $maximo  // Corregido: max_range con guion bajo
        ]
    ]);
    return $resultado;
}


function validaNumeroIntMin($postGet,$name, $minimo) {
    $resultado = filter_var($postGet[$name] ?? $minimo, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => $minimo, // Corregido: min_range con guion bajo
        ]
    ]);
    return $resultado;
}


function validaNumeroIntMax($postGet,$name, $maximo) {
    $resultado = filter_var($postGet[$name] ?? 0 , FILTER_VALIDATE_INT, [
        'options' => [
            'max_range' => $maximo  // Corregido: max_range con guion bajo
        ]
    ]);
    return $resultado;
}
function validarArrayCompleto($postGet,$name) {
    $valor = $postGet[$name] ?? [];
    if ($valor == [] || !is_array($valor)) {
        echo "El valor= " . $name . " No se esta recogiendo bien revisa el name=\"\" del html O no se selecciono nada previamente O no es un array ";
    }
    return $valor;
}
function validarArrayOpcional($postGet,$name) {
    $valor = $postGet[$name] ?? [];
    return $valor;
}
function eliminarRepetidosArray(array $datos): array {
    $resultado = array_unique($datos, SORT_REGULAR);
    return $resultado;
}


function calcularPorcentaje($cantidad, $total) {
    $porcentaje = 0;
   
    if ($total > 0) {
        $porcentaje = round(($cantidad / $total) * 100, 2);
    }
   
    return $porcentaje;
}
function calcularIVA($numero) {
    $numero * (21/100);
    return $numero;
}
function validarNumeroEntero($numero) {
    if(!is_int($numero) && !$numero >= 0) {
    throw new Exception("Error no es un numero entero", 1);
   
    }
}


function euros($numero){
    $formateado = number_format($numero, 2, ",", "."); // Mejor coma para decimales en España
    return $formateado . " €";
}


function escapar($texto){
    return htmlspecialchars($texto);
}


#foreach ($votos as $partido => $voto) {
##$votos es el array Array ( [censo] => 12 [votos] => Array ( [PSOE] => 012 [PP] => 012 [Vox] => 012 [Sumar] => 02 [Podemos] => 2 [blancos] => 12 [nulos] => 13 )
## si ponemos ($votos as voto)iteraconelvaloresdecircon1,2ox,sicolocamos(votos as partido)tambiénensucaso(votos as $partido => $voto) $partido seria el nombre del valor y voto el valor  
#}
