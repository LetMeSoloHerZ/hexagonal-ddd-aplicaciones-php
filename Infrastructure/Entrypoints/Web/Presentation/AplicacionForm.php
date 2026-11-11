<?php

declare(strict_types=1);

/**
 * Utilidades de presentacion para el formulario de Aplicacion:
 * lectura del POST, validacion amigable por campo y conversion a requests web.
 * Las reglas de negocio definitivas siguen viviendo en el dominio.
 */
final class AplicacionForm
{
    /**
     * Valores por defecto para el formulario de registro.
     *
     * @return array<string, string>
     */
    public static function defaults(): array
    {
        return array(
            'id' => '',
            'nombre' => '',
            'proveedor' => '',
            'categoria' => 'OTRA',
            'lenguajePrincipal' => '',
            'lenguajeSecundario' => '',
            'usaBd' => '0',
            'requiereConexionRed' => '0',
            'numBits' => '64',
            'sistemaOperativo' => 'MULTIPLATAFORMA',
            'requisitosHardware' => '',
            'licencia' => 'GRATUITA',
            'precio' => '0',
            'descripcion' => '',
            'web' => '',
            'correo' => '',
            'tamanoInstalador' => '',
        );
    }

    /**
     * Lee los datos enviados por POST. Las casillas se normalizan a '1' o '0'
     * y los decimales con coma se convierten a punto.
     *
     * @return array<string, string>
     */
    public static function fromPost(): array
    {
        $text = static function (string $key): string {
            return isset($_POST[$key]) ? trim((string) $_POST[$key]) : '';
        };

        $decimal = static function (string $key) use ($text): string {
            return str_replace(',', '.', $text($key));
        };

        return array(
            'id' => $text('id'),
            'nombre' => $text('nombre'),
            'proveedor' => $text('proveedor'),
            'categoria' => $text('categoria'),
            'lenguajePrincipal' => $text('lenguajePrincipal'),
            'lenguajeSecundario' => $text('lenguajeSecundario'),
            'usaBd' => isset($_POST['usaBd']) ? '1' : '0',
            'requiereConexionRed' => isset($_POST['requiereConexionRed']) ? '1' : '0',
            'numBits' => $text('numBits'),
            'sistemaOperativo' => $text('sistemaOperativo'),
            'requisitosHardware' => $text('requisitosHardware'),
            'licencia' => $text('licencia'),
            'precio' => $decimal('precio'),
            'descripcion' => $text('descripcion'),
            'web' => $text('web'),
            'correo' => $text('correo'),
            'tamanoInstalador' => $decimal('tamanoInstalador'),
        );
    }

    /**
     * @param array<string, string> $form
     * @return array<string, string>  campo => mensaje de error
     */
    public static function validate(array $form): array
    {
        $errors = array();

        if ($form['nombre'] === '') {
            $errors['nombre'] = 'El nombre es obligatorio.';
        } elseif (mb_strlen($form['nombre']) < 2 || mb_strlen($form['nombre']) > 100) {
            $errors['nombre'] = 'El nombre debe tener entre 2 y 100 caracteres.';
        }

        if ($form['proveedor'] === '') {
            $errors['proveedor'] = 'El proveedor es obligatorio.';
        } elseif (mb_strlen($form['proveedor']) > 100) {
            $errors['proveedor'] = 'El proveedor no puede superar 100 caracteres.';
        }

        if (!CategoriaAplicacionEnum::isValid($form['categoria'])) {
            $errors['categoria'] = 'Selecciona una categoría válida.';
        }

        if ($form['lenguajePrincipal'] === '') {
            $errors['lenguajePrincipal'] = 'El lenguaje principal es obligatorio.';
        } elseif (mb_strlen($form['lenguajePrincipal']) > 50) {
            $errors['lenguajePrincipal'] = 'El lenguaje principal no puede superar 50 caracteres.';
        }

        if (mb_strlen($form['lenguajeSecundario']) > 50) {
            $errors['lenguajeSecundario'] = 'El lenguaje secundario no puede superar 50 caracteres.';
        } elseif (
            $form['lenguajeSecundario'] !== ''
            && mb_strtolower($form['lenguajeSecundario']) === mb_strtolower($form['lenguajePrincipal'])
        ) {
            $errors['lenguajeSecundario'] = 'El lenguaje secundario debe ser distinto del principal.';
        }

        if (!in_array($form['numBits'], array('32', '64'), true)) {
            $errors['numBits'] = 'La arquitectura debe ser de 32 o de 64 bits.';
        }

        if (!SistemaOperativoEnum::isValid($form['sistemaOperativo'])) {
            $errors['sistemaOperativo'] = 'Selecciona un sistema operativo válido.';
        }

        if (mb_strlen($form['requisitosHardware']) > 500) {
            $errors['requisitosHardware'] = 'Los requisitos de hardware no pueden superar 500 caracteres.';
        }

        if (!LicenciaEnum::isValid($form['licencia'])) {
            $errors['licencia'] = 'Selecciona una licencia válida.';
        }

        if ($form['precio'] === '' || !is_numeric($form['precio']) || (float) $form['precio'] < 0) {
            $errors['precio'] = 'El precio debe ser un número mayor o igual a cero.';
        } elseif (!isset($errors['licencia'])) {
            $precio = (float) $form['precio'];

            if (in_array($form['licencia'], array(LicenciaEnum::GRATUITA, LicenciaEnum::OPEN_SOURCE), true) && $precio > 0) {
                $errors['precio'] = 'Una licencia ' . $form['licencia'] . ' debe tener precio 0.';
            } elseif ($form['licencia'] === LicenciaEnum::COMERCIAL && $precio <= 0) {
                $errors['precio'] = 'Una licencia COMERCIAL debe tener un precio mayor que 0.';
            }
        }

        if (mb_strlen($form['descripcion']) > 1000) {
            $errors['descripcion'] = 'La descripción no puede superar 1000 caracteres.';
        }

        if ($form['web'] !== '') {
            $scheme = strtolower((string) parse_url($form['web'], PHP_URL_SCHEME));

            if (!filter_var($form['web'], FILTER_VALIDATE_URL) || !in_array($scheme, array('http', 'https'), true)) {
                $errors['web'] = 'La web debe ser una URL válida que empiece por http:// o https://.';
            }
        }

        if ($form['correo'] === '') {
            $errors['correo'] = 'El correo es obligatorio.';
        } elseif (!filter_var($form['correo'], FILTER_VALIDATE_EMAIL)) {
            $errors['correo'] = 'El correo no tiene un formato válido.';
        }

        if ($form['tamanoInstalador'] === '' || !is_numeric($form['tamanoInstalador']) || (float) $form['tamanoInstalador'] <= 0) {
            $errors['tamanoInstalador'] = 'El tamaño del instalador debe ser un número mayor que cero (en MB).';
        }

        return $errors;
    }

    /**
     * @param array<string, string> $form
     */
    public static function toCreateRequest(array $form, string $id): CreateAplicacionWebRequest
    {
        return new CreateAplicacionWebRequest(
            $id,
            $form['nombre'],
            $form['proveedor'],
            $form['categoria'],
            $form['lenguajePrincipal'],
            $form['lenguajeSecundario'],
            $form['usaBd'] === '1',
            $form['requiereConexionRed'] === '1',
            (int) $form['numBits'],
            $form['sistemaOperativo'],
            $form['requisitosHardware'],
            $form['licencia'],
            $form['precio'],
            $form['descripcion'],
            $form['web'],
            $form['correo'],
            $form['tamanoInstalador']
        );
    }

    /**
     * @param array<string, string> $form
     */
    public static function toUpdateRequest(array $form): UpdateAplicacionWebRequest
    {
        return new UpdateAplicacionWebRequest(
            $form['id'],
            $form['nombre'],
            $form['proveedor'],
            $form['categoria'],
            $form['lenguajePrincipal'],
            $form['lenguajeSecundario'],
            $form['usaBd'] === '1',
            $form['requiereConexionRed'] === '1',
            (int) $form['numBits'],
            $form['sistemaOperativo'],
            $form['requisitosHardware'],
            $form['licencia'],
            $form['precio'],
            $form['descripcion'],
            $form['web'],
            $form['correo'],
            $form['tamanoInstalador']
        );
    }
}
