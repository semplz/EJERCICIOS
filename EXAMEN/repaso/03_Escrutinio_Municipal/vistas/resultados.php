<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Resultado del escrutinio</title></head>
<body>
<h1>Resultado ficticio del escrutinio</h1>

<!-- TODO: censo, emitidos, válidos, nulos, blancos, abstención y participación. -->
<ul>
    <li>Censo: <?= $censo ?></li>
    <li>Votos emitidos: <?= $votosEmitidos ?></li>
    <li>Votos válidos: <?= $votosValidos ?></li>
    <li>Votos en blanco: <?= $votosBlanco ?></li>
    <li>Votos nulos: <?= $votosNulo ?></li>
    <li>Abstención: <?= $abstencion ?></li>
    <li>Participación: <?= $porcentajeParticipacion ?>%</li>
</ul>

<!-- TODO: ganador o empate; número de partidos que alcanzan el 5 %. -->
<?php if ($hayEmpatePrimerPuesto): ?>
    <p><strong>¡Atención! Hay un empate en el primer puesto.</strong></p>
<?php else: ?>
    <?php $ganador = array_key_first($votosValidados); ?>
    <p>Ganador de las elecciones: <strong><?= escapar($ganador) ?></strong></p>
<?php endif; ?>

<p>Partidos que alcanzan o superan el umbral del 5%: <strong><?= $partidosSuperanUmbral ?></strong></p>

<!-- TODO: tabla de partidos por votos (descendente) y porcentaje sobre válidos. -->
<table border="1">
    <tr>
        <th>Partido</th>
        <th>Votos</th>
        <th>Porcentaje (%)</th>
    </tr>
    <?php foreach ($votosValidados as $partido => $votos): ?>
        <tr>
            <td><?= escapar($partido) ?></td>
            <td><?= $votos ?></td>
            <td><?= $porcentajes[$partido] ?> %</td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="escrutinio.html">Nuevo recuento</a></p>
</body></html>