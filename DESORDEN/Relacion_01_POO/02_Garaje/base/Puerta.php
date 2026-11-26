<?php
require_once __DIR__ . "/Ventana.php";
class Puerta {
    private bool $abierta = false;
    private Ventana $ventana;

    public function __construct() {
        $this->ventana = new Ventana();
    }

    public function abrir(): void {
        $this->abierta = true;
    }

    public function cerrar(): void {
        $this->abierta = false;
    }

    public function isAbierta(): bool {
        return $this->abierta;
    }

    public function getVentana(): Ventana {
        return $this->ventana;
    }
}