<?php
abstract class Envio {
    protected float $pesoKg;

    public function __construct(float $pesoKg) {
        if ($pesoKg > 0) {
            $this->pesoKg = $pesoKg;
        } else {
            $this->pesoKg = 0;
            echo "Aviso: El peso debe ser mayor a 0.\n";
        }
    }

    abstract public function calcularPrecio(): float;
}