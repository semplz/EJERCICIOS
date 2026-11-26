<?php

class Ventana {
    private bool $abierta = false;

    public function abrir(): void { 
        $this->abierta = true; 
    }
    
    public function cerrar(): void { 
        $this->abierta = false; 
    }
    
    public function isAbierta(): bool { 
        return $this->abierta; 
    }
}