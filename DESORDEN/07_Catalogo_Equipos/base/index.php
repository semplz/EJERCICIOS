<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/EquipoRepositorio.php';

function h(mixed $valor): string
{
    if ($valor === null) {
        return '';
    }

    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$error = '';
$equipos = [];
try {
    $repo = new EquipoRepositorio(conectar());
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $accion = (string) ($_POST['accion'] ?? '');
        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );
        if ($accion === 'crear') {
            $repo->crear(
                (string) ($_POST['nombre'] ?? ''),
                (int) ($_POST['unidades'] ?? 0)
            );
        } elseif ($accion === 'renombrar' && $id !== false) {
            $repo->actualizarUnidades($id, (int) ($_POST['unidades'] ?? 0));
        } elseif ($accion === 'borrar' && $id !== false) {
            $repo->eliminar($id);
        } else {
            throw new InvalidArgumentException('Acción no válida.');
        }
        header('Location: index.php');
        exit;
    }
    $equipos = $repo->listar();
} catch (InvalidArgumentException $errorValidacion) {
    http_response_code(400);
    $error = $errorValidacion->getMessage();
} catch (PDOException $errorBD) {
    http_response_code(500);
    $error = 'No se pudo completar la operación. Revisa la conexión o los datos duplicados.';
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Catálogo de equipos</title>
</head>

<body>
    <h1>Catálogo de equipos</h1>

    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= h($error) ?></p>
    <?php endif; ?>

    <h2>Crear equipo</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="accion" value="crear">
        <input name="nombre" placeholder="Nombre del equipo" required>
        <input type="number" name="unidades" min="0" placeholder="Unidades" required>
        <button type="submit">Crear</button>
    </form>

    <h2>Listado de equipos</h2>
    <ul>
        <?php foreach ($equipos as $equipo): ?>
            <li>
                <?= h($equipo['nombre']) ?> (<?= h($equipo['unidades']) ?> unidades)

                <form action="index.php" method="post" style="display:inline">
                    <input type="hidden" name="accion" value="renombrar">
                    <input type="hidden" name="id" value="<?= (int) $equipo['id'] ?>">
                    <input type="number" name="unidades" value="<?= h($equipo['unidades']) ?>" min="0" required>
                    <button type="submit">Actualizar Unidades</button>
                </form>

                <form action="index.php" method="post" style="display:inline">
                    <input type="hidden" name="accion" value="borrar">
                    <input type="hidden" name="id" value="<?= (int) $equipo['id'] ?>">
                    <button type="submit" onclick="return confirm('¿Estás seguro de borrar este equipo?');">Borrar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>