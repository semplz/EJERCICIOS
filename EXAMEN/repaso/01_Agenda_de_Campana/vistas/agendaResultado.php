<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de agenda</title>
</head>
<body>
    <h1>Actos encontrados</h1>
    
    <!-- TODO: mostrar los filtros, el total de coincidencias y el aforo acumulado. -->
    <p>Filtros aplicados — 
        Provincia: <strong><?php echo escapar($provinciaSeleccionada); ?></strong> | 
        Partido: <strong><?php echo escapar($partidoSeleccionado); ?></strong> | 
        Tipo: <strong><?php echo escapar($tipoSeleccionado); ?></strong> | 
        Límite: <strong><?php echo $limite; ?></strong>
    </p>
    
    <p>Coincidencias encontradas: <strong><?php echo $cantidadCoincidencias; ?></strong> | 
       Aforo acumulado total: <strong><?php echo $aforoTotal; ?> personas</strong>
    </p>

    <!-- TODO: si no hay coincidencias, indicar que la búsqueda no tiene resultados. -->
    <?php if (empty($actosVisibles)): ?>
        <p>La búsqueda no tiene resultados.</p>
    <?php else: ?>
        <!-- TODO: tabla con fecha, hora, provincia, partido, tipo, lugar y aforo. -->
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Provincia</th>
                    <th>Partido</th>
                    <th>Tipo</th>
                    <th>Lugar</th>
                    <th>Aforo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($actosVisibles as $acto): ?>
                    <tr>
                        <td><?php echo escapar($acto['fecha']); ?></td>
                        <td><?php echo escapar($acto['hora']); ?></td>
                        <td><?php echo escapar($acto['provincia']); ?></td>
                        <td><?php echo escapar($acto['partido']); ?></td>
                        <td><?php echo escapar($acto['tipo']); ?></td>
                        <td><?php echo escapar($acto['lugar']); ?></td>
                        <td><?php echo escapar($acto['aforo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="agenda.html">Nueva búsqueda</a></p>
</body>
</html>
