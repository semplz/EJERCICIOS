<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Informe del pacto</title></head>
<body>
<h1>Informe del pacto (simulación)</h1>

<!-- TODO: nombre de la Asamblea, total escaños, umbral mayoría y socios. -->
<h2>Datos generales</h2>
<ul>
    <li>Asamblea: <strong><?= escapar($escenarios[$escenario]['nombre']) ?></strong></li>
    <li>Total de escaños: <?= $escenarios[$escenario]['escanos'] ?></li>
    <li>Umbral de mayoría absoluta: <?= $mayoriaAbsoluta ?></li>
    <li>Socios seleccionados: <strong><?= escapar(implode(', ', $sociosValidados)) ?></strong></li>
</ul>

<!-- TODO: escaños pactados y diagnóstico de mayoría, con diferencia. -->
<h2>Diagnóstico del pacto</h2>
<ul>
    <li>Escaños pactados: <strong><?= $escanosSocios ?></strong></li>
    <li>¿Tiene mayoría absoluta?: <strong><?= $textoMayoria ?></strong></li>
    <li>Detalle: <?= escapar($diferenciaTexto) ?></li>
</ul>

<!-- TODO: tabla de partidos que quedan fuera y qué pasaría si se incorporasen. -->
<h2>Ampliación con partidos externos</h2>
<table border="1">
    <tr>
        <th>Partido</th>
        <th>Escaños propios</th>
        <th>Escaños totales juntos</th>
        <th>¿Alcanza mayoría?</th>
    </tr>
    <?php foreach ($alternativas as $partidoExt => $datos): ?>
        <tr>
            <td><?= escapar($partidoExt) ?></td>
            <td><?= $escenarios[$escenario]['partidos'][$partidoExt] ?></td>
            <td><?= $datos['escanos'] ?></td>
            <td><?= $datos['alcanzaMayoria'] ? 'Sí' : 'No' ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<!-- TODO: informar del socio adicional válido de menor aportación, si existe. -->
<h2>Socio óptimo adicional</h2>
<p><?= $mensajeSocioOptimo ?></p>

<p><a href="pactos.html">Analizar otro pacto</a></p>
</body></html>