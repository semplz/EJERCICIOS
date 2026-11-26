<?php

// Autocargador automático: busca y carga el archivo .php que coincida con el nombre de la clase
spl_autoload_register(function ($clase) {
    $archivo = __DIR__ . '/' . $clase . '.php';
    if (file_exists($archivo)) {
        require_once $archivo;
    }
});

// --- BLOQUE DE PRUEBAS ---
try {
    echo "<h3>Pruebas del Coche</h3>";
    
    $miCoche = new Coche(4);

    // 1. Ventanas independientes
    $miCoche->getPuerta(0)->getVentana()->abrir();
    echo "Ventana de puerta 0 abierta: " . ($miCoche->getPuerta(0)->getVentana()->isAbierta() ? 'Sí' : 'No') . "<br>";
    echo "Ventana de puerta 1 abierta: " . ($miCoche->getPuerta(1)->getVentana()->isAbierta() ? 'Sí' : 'No') . "<br><br>";

    // 2. Abrir puertas y resumen
    $miCoche->abrirPuerta(0);
    $miCoche->abrirPuerta(2);
    echo $miCoche->resumen() . "<br><br>";

    // 3. Cerrar todo
    $miCoche->cerrarTodo();
    echo "Tras cerrar todo - Puertas abiertas: " . $miCoche->numeroPuertasAbiertas() . "<br><br>";

    // 4. Provocar excepción por índice inválido
    echo "Intentando abrir puerta 99...<br>";
    $miCoche->abrirPuerta(99);

} catch (Exception $e) {
    echo "<b>Excepción capturada:</b> " . $e->getMessage();
}