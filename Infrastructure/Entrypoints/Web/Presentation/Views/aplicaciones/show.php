<?php
require __DIR__ . '/../layouts/header.php';
require __DIR__ . '/../layouts/menu.php';

$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
$yesNo = static function (bool $value): string {
    return $value ? 'Sí' : 'No';
};
$empty = '<em>No registrado</em>';
?>

<h1>Detalle de aplicación</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= $e($message) ?>
    </div>
<?php endif; ?>

<table class="detail-table">
    <tr>
        <th>ID</th>
        <td><?= $e($aplicacion->getId()) ?></td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><?= $e($aplicacion->getNombre()) ?></td>
    </tr>
    <tr>
        <th>Proveedor</th>
        <td><?= $e($aplicacion->getProveedor()) ?></td>
    </tr>
    <tr>
        <th>Categoría</th>
        <td><?= $e($aplicacion->getCategoria()) ?></td>
    </tr>
    <tr>
        <th>Lenguaje principal</th>
        <td><?= $e($aplicacion->getLenguajePrincipal()) ?></td>
    </tr>
    <tr>
        <th>Lenguaje secundario</th>
        <td><?= $aplicacion->getLenguajeSecundario() !== null ? $e($aplicacion->getLenguajeSecundario()) : $empty ?></td>
    </tr>
    <tr>
        <th>Usa base de datos</th>
        <td><?= $yesNo($aplicacion->getUsaBd()) ?></td>
    </tr>
    <tr>
        <th>Requiere conexión de red</th>
        <td><?= $yesNo($aplicacion->getRequiereConexionRed()) ?></td>
    </tr>
    <tr>
        <th>Arquitectura</th>
        <td><?= $e($aplicacion->getNumBits()) ?> bits</td>
    </tr>
    <tr>
        <th>Sistema operativo</th>
        <td><?= $e($aplicacion->getSistemaOperativo()) ?></td>
    </tr>
    <tr>
        <th>Requisitos de hardware</th>
        <td><?= $aplicacion->getRequisitosHardware() !== null ? $e($aplicacion->getRequisitosHardware()) : $empty ?></td>
    </tr>
    <tr>
        <th>Licencia</th>
        <td><?= $e($aplicacion->getLicencia()) ?></td>
    </tr>
    <tr>
        <th>Precio</th>
        <td><?= $e($aplicacion->getPrecio()) ?></td>
    </tr>
    <tr>
        <th>Descripción</th>
        <td><?= $aplicacion->getDescripcion() !== null ? $e($aplicacion->getDescripcion()) : $empty ?></td>
    </tr>
    <tr>
        <th>Sitio web</th>
        <td>
            <?php if ($aplicacion->getWeb() !== null): ?>
                <a href="<?= $e($aplicacion->getWeb()) ?>" target="_blank" rel="noopener noreferrer"><?= $e($aplicacion->getWeb()) ?></a>
            <?php else: ?>
                <?= $empty ?>
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <th>Correo de contacto</th>
        <td><?= $e($aplicacion->getCorreo()) ?></td>
    </tr>
    <tr>
        <th>Tamaño del instalador</th>
        <td><?= $e($aplicacion->getTamanoInstalador()) ?> MB</td>
    </tr>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=aplicaciones.edit&amp;id=<?= urlencode($aplicacion->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=aplicaciones.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
