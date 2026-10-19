<?php
// TODO: función calcularMayoria($totalEscanos) que devuelva intdiv($totalEscanos, 2) + 1.
function calcularMayoria(int $totalEscanos): int {
    return intdiv($totalEscanos, 2) + 1;
}
// TODO: función escapar($valor) para mostrar texto seguro en HTML.
function escapar($valor): string {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}