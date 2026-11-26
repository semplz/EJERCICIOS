<!DOCTYPE html>
<html lang="es"><head><meta charset="UTF-8"><title>Ticket del pedido</title></head>
<body>
<h1>Ticket de material electoral</h1>

<!-- TODO: tabla o lista con partido, pack, unidades, extras y transporte. -->
<ul>
    <li>Partido: <strong><?= escapar($partido) ?></strong></li>
    <li>Pack seleccionado: <strong><?= escapar($packs[$pack]['nombre']) ?></strong> (<?= euros($packs[$pack]['precio']) ?>)</li>
    <li>Unidades solicitadas: <?= $unidades ?></li>
    <li>Extras seleccionados: 
        <?php if (empty($extrasValidados)): ?>
            Ninguno
        <?php else: ?>
            <ul>
                <?php foreach ($extrasValidados as $extra): ?>
                    <li><?= escapar($extras[$extra]['nombre']) ?> — <?= euros($extras[$extra]['precio']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </li>
    <li>Transporte: <strong><?= escapar($transporte) ?></strong> (<?= euros($costeTransporte) ?>)</li>
</ul>

<!-- TODO: mostrar subtotal, descuento, transporte, base, IVA y total. -->
<hr>
<ul>
    <li>Precio unitario (Pack + Extras): <strong><?= euros($precioUnitario) ?></strong></li>
    <li>Subtotal mercancía: <?= euros($mercancia) ?></li>
    
    <?php if ($codigoInput !== ''): ?>
        <li>Descuento aplicado (<?= escapar($codigoInput) ?> - <?= $descuentoPorcentaje ?>%): -<?= euros($importeDescuento) ?></li>
    <?php endif; ?>
    
    <li>Coste de transporte: <?= euros($costeTransporte) ?></li>
    <li>Base con transporte: <?= euros($baseConTransporte) ?></li>
    <li>IVA (21%): <?= euros($importeIva) ?></li>
    <li><h2>Total final: <?= euros($totalFinal) ?></h2></li>
</ul>

<!-- TODO: mensaje distinto dependiendo de si se superan los 500 €. -->
<?php if ($superaPresupuesto): ?>
    <p style="color: red;"><strong>¡Atención!</strong> Este pedido supera el límite máximo de 500 €.</p>
<?php else: ?>
    <p style="color: green;">El pedido está dentro del presupuesto permitido (no supera los 500 €).</p>
<?php endif; ?>

<p><a href="pedido.html">Volver al formulario</a></p>
</body></html>