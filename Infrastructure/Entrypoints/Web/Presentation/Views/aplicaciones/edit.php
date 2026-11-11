<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Editar aplicación</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error">
        <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php
$action = '?route=aplicaciones.update';
$submitLabel = 'Guardar cambios';
$cancelUrl = '?route=aplicaciones.index';
$isEdit = true;
require __DIR__ . '/_form.php';
?>

<script src="../Infrastructure/Entrypoints/Web/Presentation/js/validaciones-aplicaciones.js"></script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
