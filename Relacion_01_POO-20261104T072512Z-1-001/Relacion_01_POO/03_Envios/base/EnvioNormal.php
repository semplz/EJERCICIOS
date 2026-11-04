<?php
require_once __DIR__ . "/Envio.php";
class EnvioNormal extends Envio { /* TODO */ 
    public function calcularPrecio(): float
    {
        return 4.0 + (1.50 * $this->pesoKg);
    }
}
    

