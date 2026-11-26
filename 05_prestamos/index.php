<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EquipoRepositorio.php';

$pdo = conectar();
$repositorio = new EquipoRepositorio($pdo);

$mensaje = "";

// Comprobar si se ha enviado un formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    try {

        if ($_POST['accion'] === 'prestar') {

            $equipoId = (int) $_POST['equipo_id'];
            $persona = trim($_POST['persona']);

            if ($persona === '') {
                throw new Exception("Escribe el nombre de la persona.");
            }

            $repositorio->prestar($equipoId, $persona);

            header("Location: index.php");
            exit;
        }

        if ($_POST['accion'] === 'devolver') {

            $prestamoId = (int) $_POST['prestamo_id'];

            if ($repositorio->devolver($prestamoId)) {
                header("Location: index.php");
                exit;
            } else {
                $mensaje = "El préstamo ya está devuelto.";
            }
        }

    } catch (Exception $e) {
        $mensaje = $e->getMessage();
    }
}

// Obtener equipos y préstamos
$equipos = $repositorio->listarEquipos();
$prestamos = $repositorio->listarPrestamos();

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Préstamos de equipos</title>
</head>

<body>

    <h1>Préstamos de equipos</h1>

    <?php if ($mensaje !== ''): ?>
        <p><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>


    <h2>Equipos</h2>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Unidades</th>
            <th>Disponibles</th>
        </tr>

        <?php foreach ($equipos as $equipo): ?>

            <tr>
                <td><?php echo htmlspecialchars((string) $equipo['id']); ?></td>
                <td><?php echo htmlspecialchars($equipo['nombre']); ?></td>
                <td><?php echo htmlspecialchars((string) $equipo['unidades']); ?></td>
                <td><?php echo htmlspecialchars((string) $equipo['disponibles']); ?></td>
            </tr>

        <?php endforeach; ?>

    </table>


    <h2>Prestar un equipo</h2>

    <form method="POST">

        <label>Equipo:</label>

        <select name="equipo_id" required>

            <?php foreach ($equipos as $equipo): ?>

                <?php if ($equipo['disponibles'] > 0): ?>

                    <option value="<?php echo $equipo['id']; ?>">
                        <?php echo htmlspecialchars($equipo['nombre']); ?>
                    </option>

                <?php endif; ?>

            <?php endforeach; ?>

        </select>

        <br><br>

        <label>Nombre de la persona:</label>

        <input type="text" name="persona" required>

        <input type="hidden" name="accion" value="prestar">

        <button type="submit">Prestar</button>

    </form>


    <h2>Lista de préstamos</h2>

    <table border="1">

        <tr>
            <th>ID</th>
            <th>Equipo</th>
            <th>Persona</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>

        <?php foreach ($prestamos as $prestamo): ?>

            <tr>

                <td><?php echo htmlspecialchars((string) $prestamo['id']); ?></td>

                <td><?php echo htmlspecialchars($prestamo['nombre']); ?></td>

                <td><?php echo htmlspecialchars($prestamo['persona']); ?></td>

                <td>
                    <?php
                    if ($prestamo['fecha_devolucion'] === null) {
                        echo "Prestado";
                    } else {
                        echo "Devuelto";
                    }
                    ?>
                </td>

                <td>

                    <?php if ($prestamo['fecha_devolucion'] === null): ?>

                        <form method="POST">

                            <input type="hidden" name="prestamo_id"
                                value="<?php echo $prestamo['id']; ?>">

                            <input type="hidden" name="accion" value="devolver">

                            <button type="submit">Devolver</button>

                        </form>

                    <?php endif; ?>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

</body>
</html>
