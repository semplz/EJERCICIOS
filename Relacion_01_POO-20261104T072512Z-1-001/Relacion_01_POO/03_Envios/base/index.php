<?php
// TODO: instanciar tipos y mostrar resultados.
require_once 'EnvioNormal.php';
require_once 'EnvioExpress.php';

$peso = 4.0;

// Creamos los envíos
$envioNormal = new EnvioNormal($peso);
$envioExpress = new EnvioExpress($peso);

$envios = [$envioNormal, $envioExpress];
foreach ($envios as $envio) {
    echo get_class($envio) . " - Precio: " . $envio->calcularPrecio() . " €\n";
    if ($envio instanceof Rastreable) {
        echo "Código de seguimiento: " . $envio->codigoSeguimiento() . "\n";
    }
    
    echo "---------------------------\n";
}