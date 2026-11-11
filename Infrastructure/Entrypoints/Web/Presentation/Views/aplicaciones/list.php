<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de aplicaciones</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert-success">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<p>
    <a class="btn btn-primary" href="?route=aplicaciones.create">Registrar aplicación</a>
</p>

<?php if (empty($aplicaciones)): ?>
    <p>No hay aplicaciones registradas todavía.</p>
<?php else: ?>
    <p>
        <label for="buscar-aplicacion">Buscar:</label>
        <input type="search" id="buscar-aplicacion" placeholder="Nombre, proveedor, categoría…"
            oninput="filterAplicaciones(this, 'tabla-aplicaciones');">
    </p>

    <table id="tabla-aplicaciones">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Proveedor</th>
                <th>Categoría</th>
                <th>Sistema operativo</th>
                <th>Licencia</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($aplicaciones as $app): ?>
                <tr>
                    <td><?= htmlspecialchars($app->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($app->getProveedor(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($app->getCategoria(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($app->getSistemaOperativo(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($app->getLicencia(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($app->getPrecio(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="col-actions">
                        <a class="btn btn-sm"
                            href="?route=aplicaciones.show&amp;id=<?= urlencode($app->getId()) ?>">Ver</a>
                        <a class="btn btn-warning btn-sm"
                            href="?route=aplicaciones.edit&amp;id=<?= urlencode($app->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=aplicaciones.delete" style="display:inline;"
                            onsubmit="return confirmDeleteAplicacion(this);"
                            data-name="<?= htmlspecialchars($app->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
                            <input type="hidden" name="id"
                                value="<?= htmlspecialchars($app->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<script src="../Infrastructure/Entrypoints/Web/Presentation/js/validaciones-aplicaciones.js"></script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
