<?php

class Coche {
    /** @var Puerta[] */
    private array $puertas = [];

    public function __construct(int $numPuertas = 4) {
        for ($i = 0; $i < $numPuertas; $i++) {
            $this->puertas[] = new Puerta();
        }
    }

    public function abrirPuerta(int $indice): void {
        $this->validarIndice($indice);
        $this->puertas[$indice]->abrir();
    }

    public function cerrarTodo(): void {
        foreach ($this->puertas as $puerta) {
            $puerta->cerrar();
            $puerta->getVentana()->cerrar();
        }
    }

    public function numeroPuertasAbiertas(): int {
        $contador = 0;
        foreach ($this->puertas as $puerta) {
            if ($puerta->isAbierta()) {
                $contador++;
            }
        }
        return $contador;
    }

    public function resumen(): string {
        return "Coche -> Total puertas: " . count($this->puertas) . " | Abiertas: " . $this->numeroPuertasAbiertas();
    }

    public function getPuerta(int $indice): Puerta {
        $this->validarIndice($indice);
        return $this->puertas[$indice];
    }

    private function validarIndice(int $indice): void {
        if ($indice < 0 || $indice >= count($this->puertas)) {
            throw new Exception("Error: Índice de puerta [{$indice}] inválido.");
        }
    }
}