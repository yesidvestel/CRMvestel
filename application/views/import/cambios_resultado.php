<!DOCTYPE html>
<html>
<head>
    <title>Cambios Realizados</title>
</head>
<body>
    <h2>Resultado de la importación</h2>

    <?php if (!empty($cambios)): ?>
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nuevo Estado</th>
                    <th>Factura Actualizada</th>
                </tr>
            </thead>
            <tbody>
                <tbody>
					<?php foreach ($cambios as $cambio): ?>
						<?php if (is_array($cambio)): ?>
							<tr>
								<td><?= htmlspecialchars($cambio['id']) ?></td>
								<td><?= htmlspecialchars($cambio['estado']) ?></td>
								<td><?= $cambio['factura_actualizada'] ? 'Sí' : 'No' ?></td>
							</tr>
						<?php else: ?>
							<tr>
								<td colspan="3"><?= htmlspecialchars($cambio) ?></td>
							</tr>
						<?php endif; ?>
					<?php endforeach; ?>
				</tbody>

            </tbody>
        </table>
    <?php else: ?>
        <p>No se realizaron cambios.</p>
    <?php endif; ?>
</body>
</html>

