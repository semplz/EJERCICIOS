<?php
/* TODO: extends Envio implements Rastreable */
class EnvioExpress extends Envio
{
    public function calcularPrecio(): float
    {
        // 9 € fijo + 2,75 € por kg
        return 9.0 + (2.75 * $this->pesoKg);
    }
}