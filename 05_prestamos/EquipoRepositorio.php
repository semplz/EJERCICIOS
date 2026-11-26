<?php
declare(strict_types=1);

class EquipoRepositorio
{


    public function listarEquipos(): array
    {

        $sql = "SELECT * FROM equipo";
        $consulta = $this->pdo->query($sql);
        $equipos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM prestamo WHERE fecha_devolucion IS NULL";
        $consulta = $this->pdo->query($sql);
        $prestamos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        foreach ($equipos as &$equipo) {

            $disponibles = $equipo['unidades'];

            foreach ($prestamos as $prestamo) {

                if ($prestamo['equipo_id'] == $equipo['id']) {
                    $disponibles--;
                }
            }

            $equipo['disponibles'] = $disponibles;
        }

        return $equipos;
    }

    public function listarPrestamos(): array
    {

        $sql = "SELECT prestamo.id, equipo.nombre, prestamo.persona,
            prestamo.fecha_devolucion
            FROM prestamo
            INNER JOIN equipo ON prestamo.equipo_id = equipo.id
            ORDER BY prestamo.id DESC";

        $consulta = $this->pdo->query($sql);

        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prestar(int $equipoId, string $persona): void
    {

        $sql = "SELECT * FROM equipo WHERE id = ?";
        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$equipoId]);

        $equipo = $consulta->fetch(PDO::FETCH_ASSOC);

        if (!$equipo) {
            throw new Exception("El equipo no existe.");
        }

        $sql = "SELECT COUNT(*) FROM prestamo
            WHERE equipo_id = ? AND fecha_devolucion IS NULL";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$equipoId]);

        $prestados = $consulta->fetchColumn();

        if ($prestados >= $equipo['unidades']) {
            throw new Exception("No quedan unidades disponibles.");
        }

        $sql = "INSERT INTO prestamo (equipo_id, persona, fecha_prestamo)
            VALUES (?, ?, NOW())";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$equipoId, $persona]);
    }

    public function devolver(int $prestamoId): bool
    {

        $sql = "UPDATE prestamo
            SET fecha_devolucion = NOW()
            WHERE id = ? AND fecha_devolucion IS NULL";

        $consulta = $this->pdo->prepare($sql);
        $consulta->execute([$prestamoId]);

        return $consulta->rowCount() > 0;
    }

}
