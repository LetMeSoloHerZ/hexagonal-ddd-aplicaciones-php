<?php
/**
 * Formulario compartido de registro/edicion de aplicaciones.
 *
 * Variables esperadas: $values, $errors, $action, $submitLabel, $cancelUrl,
 * $categoriaOptions, $sistemaOperativoOptions, $licenciaOptions, $isEdit.
 */
$e = static function ($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

$fieldError = static function (array $errors, string $field) use ($e): string {
    return !empty($errors[$field])
        ? '<div class="field-error">' . $e($errors[$field]) . '</div>'
        : '';
};
?>
<form method="POST" action="<?= $e($action) ?>" onsubmit="return validateAplicacionForm(this);" novalidate>
    <?php if (!empty($isEdit)): ?>
        <input type="hidden" name="id" value="<?= $e($values['id']) ?>">
    <?php endif; ?>

    <div class="form-group">
        <label for="nombre">Nombre *</label><br>
        <input type="text" id="nombre" name="nombre" maxlength="100" value="<?= $e($values['nombre']) ?>">
        <?= $fieldError($errors, 'nombre') ?>
    </div>

    <div class="form-group">
        <label for="proveedor">Proveedor *</label><br>
        <input type="text" id="proveedor" name="proveedor" maxlength="100" value="<?= $e($values['proveedor']) ?>">
        <?= $fieldError($errors, 'proveedor') ?>
    </div>

    <div class="form-group">
        <label for="categoria">Categoría *</label><br>
        <select id="categoria" name="categoria">
            <?php foreach ($categoriaOptions as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= ($values['categoria'] === $opt) ? 'selected' : '' ?>><?= $e($opt) ?></option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError($errors, 'categoria') ?>
    </div>

    <div class="form-group">
        <label for="lenguajePrincipal">Lenguaje principal *</label><br>
        <input type="text" id="lenguajePrincipal" name="lenguajePrincipal" maxlength="50"
            value="<?= $e($values['lenguajePrincipal']) ?>">
        <?= $fieldError($errors, 'lenguajePrincipal') ?>
    </div>

    <div class="form-group">
        <label for="lenguajeSecundario">Lenguaje secundario <small>(opcional)</small></label><br>
        <input type="text" id="lenguajeSecundario" name="lenguajeSecundario" maxlength="50"
            value="<?= $e($values['lenguajeSecundario']) ?>">
        <?= $fieldError($errors, 'lenguajeSecundario') ?>
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="usaBd" value="1" <?= ($values['usaBd'] === '1') ? 'checked' : '' ?>>
            Usa base de datos</label>
    </div>

    <div class="form-group">
        <label><input type="checkbox" name="requiereConexionRed" value="1"
                <?= ($values['requiereConexionRed'] === '1') ? 'checked' : '' ?>>
            Requiere conexión de red</label>
    </div>

    <div class="form-group">
        <label for="numBits">Arquitectura (bits) *</label><br>
        <select id="numBits" name="numBits">
            <?php foreach (array('32', '64') as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= ($values['numBits'] === $opt) ? 'selected' : '' ?>><?= $e($opt) ?> bits</option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError($errors, 'numBits') ?>
    </div>

    <div class="form-group">
        <label for="sistemaOperativo">Sistema operativo *</label><br>
        <select id="sistemaOperativo" name="sistemaOperativo">
            <?php foreach ($sistemaOperativoOptions as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= ($values['sistemaOperativo'] === $opt) ? 'selected' : '' ?>><?= $e($opt) ?></option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError($errors, 'sistemaOperativo') ?>
    </div>

    <div class="form-group">
        <label for="requisitosHardware">Requisitos de hardware <small>(opcional)</small></label><br>
        <textarea id="requisitosHardware" name="requisitosHardware" rows="2" cols="50"
            maxlength="500"><?= $e($values['requisitosHardware']) ?></textarea>
        <?= $fieldError($errors, 'requisitosHardware') ?>
    </div>

    <div class="form-group">
        <label for="licencia">Licencia *</label><br>
        <select id="licencia" name="licencia">
            <?php foreach ($licenciaOptions as $opt): ?>
                <option value="<?= $e($opt) ?>" <?= ($values['licencia'] === $opt) ? 'selected' : '' ?>><?= $e($opt) ?></option>
            <?php endforeach; ?>
        </select>
        <?= $fieldError($errors, 'licencia') ?>
    </div>

    <div class="form-group">
        <label for="precio">Precio *</label><br>
        <input type="text" id="precio" name="precio" inputmode="decimal" value="<?= $e($values['precio']) ?>">
        <small>GRATUITA y OPEN_SOURCE llevan precio 0; COMERCIAL debe ser mayor que 0.</small>
        <?= $fieldError($errors, 'precio') ?>
    </div>

    <div class="form-group">
        <label for="descripcion">Descripción <small>(opcional)</small></label><br>
        <textarea id="descripcion" name="descripcion" rows="3" cols="50"
            maxlength="1000"><?= $e($values['descripcion']) ?></textarea>
        <?= $fieldError($errors, 'descripcion') ?>
    </div>

    <div class="form-group">
        <label for="web">Sitio web <small>(opcional)</small></label><br>
        <input type="text" id="web" name="web" maxlength="255" placeholder="https://..."
            value="<?= $e($values['web']) ?>">
        <?= $fieldError($errors, 'web') ?>
    </div>

    <div class="form-group">
        <label for="correo">Correo de contacto *</label><br>
        <input type="email" id="correo" name="correo" maxlength="120" value="<?= $e($values['correo']) ?>">
        <?= $fieldError($errors, 'correo') ?>
    </div>

    <div class="form-group">
        <label for="tamanoInstalador">Tamaño del instalador (MB) *</label><br>
        <input type="text" id="tamanoInstalador" name="tamanoInstalador" inputmode="decimal"
            value="<?= $e($values['tamanoInstalador']) ?>">
        <?= $fieldError($errors, 'tamanoInstalador') ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $e($submitLabel) ?></button>
    &nbsp;
    <a class="btn" href="<?= $e($cancelUrl) ?>">Cancelar</a>
</form>
