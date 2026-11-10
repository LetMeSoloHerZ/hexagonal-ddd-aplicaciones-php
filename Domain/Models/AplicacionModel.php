<?php

declare(strict_types=1);

require_once __DIR__ . '/../ValueObjects/AplicacionId.php';
require_once __DIR__ . '/../ValueObjects/AplicacionNombre.php';
require_once __DIR__ . '/../ValueObjects/AplicacionCorreo.php';
require_once __DIR__ . '/../ValueObjects/AplicacionWeb.php';
require_once __DIR__ . '/../ValueObjects/Precio.php';
require_once __DIR__ . '/../ValueObjects/TamanoInstalador.php';
require_once __DIR__ . '/../Enums/CategoriaAplicacionEnum.php';
require_once __DIR__ . '/../Enums/SistemaOperativoEnum.php';
require_once __DIR__ . '/../Enums/LicenciaEnum.php';
require_once __DIR__ . '/../Exceptions/InvalidAplicacionException.php';

final class AplicacionModel
{
    const ALLOWED_BITS = array(32, 64);

    private AplicacionId $id;
    private AplicacionNombre $nombre;
    private string $proveedor;
    private string $categoria;
    private string $lenguajePrincipal;
    private ?string $lenguajeSecundario;
    private bool $usaBd;
    private bool $requiereConexionRed;
    private int $numBits;
    private string $sistemaOperativo;
    private ?string $requisitosHardware;
    private string $licencia;
    private Precio $precio;
    private ?string $descripcion;
    private ?AplicacionWeb $web;
    private AplicacionCorreo $correo;
    private TamanoInstalador $tamanoInstalador;

    public function __construct(
        AplicacionId $id,
        AplicacionNombre $nombre,
        string $proveedor,
        string $categoria,
        string $lenguajePrincipal,
        ?string $lenguajeSecundario,
        bool $usaBd,
        bool $requiereConexionRed,
        int $numBits,
        string $sistemaOperativo,
        ?string $requisitosHardware,
        string $licencia,
        Precio $precio,
        ?string $descripcion,
        ?AplicacionWeb $web,
        AplicacionCorreo $correo,
        TamanoInstalador $tamanoInstalador
    ) {
        $proveedor = self::requiredText($proveedor, 'proveedor', 100);
        $lenguajePrincipal = self::requiredText($lenguajePrincipal, 'lenguajePrincipal', 50);
        $lenguajeSecundario = self::optionalText($lenguajeSecundario, 'lenguajeSecundario', 50);
        $requisitosHardware = self::optionalText($requisitosHardware, 'requisitosHardware', 500);
        $descripcion = self::optionalText($descripcion, 'descripcion', 1000);

        CategoriaAplicacionEnum::ensureIsValid($categoria);
        SistemaOperativoEnum::ensureIsValid($sistemaOperativo);
        LicenciaEnum::ensureIsValid($licencia);

        if (!in_array($numBits, self::ALLOWED_BITS, true)) {
            throw InvalidAplicacionException::becauseBitsAreInvalid($numBits);
        }

        if ($lenguajeSecundario !== null && mb_strtolower($lenguajeSecundario) === mb_strtolower($lenguajePrincipal)) {
            throw InvalidAplicacionException::becauseSecondaryLanguageEqualsPrimary($lenguajePrincipal);
        }

        self::ensureLicenseMatchesPrice($licencia, $precio);

        $this->id = $id;
        $this->nombre = $nombre;
        $this->proveedor = $proveedor;
        $this->categoria = $categoria;
        $this->lenguajePrincipal = $lenguajePrincipal;
        $this->lenguajeSecundario = $lenguajeSecundario;
        $this->usaBd = $usaBd;
        $this->requiereConexionRed = $requiereConexionRed;
        $this->numBits = $numBits;
        $this->sistemaOperativo = $sistemaOperativo;
        $this->requisitosHardware = $requisitosHardware;
        $this->licencia = $licencia;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->web = $web;
        $this->correo = $correo;
        $this->tamanoInstalador = $tamanoInstalador;
    }

    /**
     * Named constructor: registra una aplicacion nueva.
     */
    public static function create(
        AplicacionId $id,
        AplicacionNombre $nombre,
        string $proveedor,
        string $categoria,
        string $lenguajePrincipal,
        ?string $lenguajeSecundario,
        bool $usaBd,
        bool $requiereConexionRed,
        int $numBits,
        string $sistemaOperativo,
        ?string $requisitosHardware,
        string $licencia,
        Precio $precio,
        ?string $descripcion,
        ?AplicacionWeb $web,
        AplicacionCorreo $correo,
        TamanoInstalador $tamanoInstalador
    ): self {
        return new self(
            $id,
            $nombre,
            $proveedor,
            $categoria,
            $lenguajePrincipal,
            $lenguajeSecundario,
            $usaBd,
            $requiereConexionRed,
            $numBits,
            $sistemaOperativo,
            $requisitosHardware,
            $licencia,
            $precio,
            $descripcion,
            $web,
            $correo,
            $tamanoInstalador
        );
    }

    /**
     * Devuelve una nueva instancia con los datos actualizados y el mismo id (inmutabilidad).
     */
    public function update(
        AplicacionNombre $nombre,
        string $proveedor,
        string $categoria,
        string $lenguajePrincipal,
        ?string $lenguajeSecundario,
        bool $usaBd,
        bool $requiereConexionRed,
        int $numBits,
        string $sistemaOperativo,
        ?string $requisitosHardware,
        string $licencia,
        Precio $precio,
        ?string $descripcion,
        ?AplicacionWeb $web,
        AplicacionCorreo $correo,
        TamanoInstalador $tamanoInstalador
    ): self {
        return new self(
            $this->id,
            $nombre,
            $proveedor,
            $categoria,
            $lenguajePrincipal,
            $lenguajeSecundario,
            $usaBd,
            $requiereConexionRed,
            $numBits,
            $sistemaOperativo,
            $requisitosHardware,
            $licencia,
            $precio,
            $descripcion,
            $web,
            $correo,
            $tamanoInstalador
        );
    }

    public function id(): AplicacionId
    {
        return $this->id;
    }

    public function nombre(): AplicacionNombre
    {
        return $this->nombre;
    }

    public function proveedor(): string
    {
        return $this->proveedor;
    }

    public function categoria(): string
    {
        return $this->categoria;
    }

    public function lenguajePrincipal(): string
    {
        return $this->lenguajePrincipal;
    }

    public function lenguajeSecundario(): ?string
    {
        return $this->lenguajeSecundario;
    }

    public function usaBd(): bool
    {
        return $this->usaBd;
    }

    public function requiereConexionRed(): bool
    {
        return $this->requiereConexionRed;
    }

    public function numBits(): int
    {
        return $this->numBits;
    }

    public function sistemaOperativo(): string
    {
        return $this->sistemaOperativo;
    }

    public function requisitosHardware(): ?string
    {
        return $this->requisitosHardware;
    }

    public function licencia(): string
    {
        return $this->licencia;
    }

    public function precio(): Precio
    {
        return $this->precio;
    }

    public function descripcion(): ?string
    {
        return $this->descripcion;
    }

    public function web(): ?AplicacionWeb
    {
        return $this->web;
    }

    public function correo(): AplicacionCorreo
    {
        return $this->correo;
    }

    public function tamanoInstalador(): TamanoInstalador
    {
        return $this->tamanoInstalador;
    }

    public function toArray(): array
    {
        return array(
            'id' => $this->id->value(),
            'nombre' => $this->nombre->value(),
            'proveedor' => $this->proveedor,
            'categoria' => $this->categoria,
            'lenguajePrincipal' => $this->lenguajePrincipal,
            'lenguajeSecundario' => $this->lenguajeSecundario,
            'usaBd' => $this->usaBd,
            'requiereConexionRed' => $this->requiereConexionRed,
            'numBits' => $this->numBits,
            'sistemaOperativo' => $this->sistemaOperativo,
            'requisitosHardware' => $this->requisitosHardware,
            'licencia' => $this->licencia,
            'precio' => $this->precio->value(),
            'descripcion' => $this->descripcion,
            'web' => $this->web === null ? null : $this->web->value(),
            'correo' => $this->correo->value(),
            'tamanoInstalador' => $this->tamanoInstalador->value(),
        );
    }

    /**
     * Regla de negocio: la licencia condiciona el precio.
     * GRATUITA y OPEN_SOURCE => precio 0; COMERCIAL => precio mayor que 0.
     */
    private static function ensureLicenseMatchesPrice(string $licencia, Precio $precio): void
    {
        $freeLicenses = array(LicenciaEnum::GRATUITA, LicenciaEnum::OPEN_SOURCE);

        if (in_array($licencia, $freeLicenses, true) && !$precio->isZero()) {
            throw InvalidAplicacionException::becauseLicenseRequiresZeroPrice($licencia);
        }

        if ($licencia === LicenciaEnum::COMERCIAL && $precio->isZero()) {
            throw InvalidAplicacionException::becauseLicenseRequiresPositivePrice($licencia);
        }
    }

    private static function requiredText(string $value, string $field, int $maxLength): string
    {
        $normalized = trim($value);

        if ($normalized === '') {
            throw InvalidAplicacionException::becauseFieldIsEmpty($field);
        }

        if (mb_strlen($normalized) > $maxLength) {
            throw InvalidAplicacionException::becauseFieldIsTooLong($field, $maxLength);
        }

        return $normalized;
    }

    private static function optionalText(?string $value, string $field, int $maxLength): ?string
    {
        if ($value === null) {
            return null;
        }

        $normalized = trim($value);

        if ($normalized === '') {
            return null;
        }

        if (mb_strlen($normalized) > $maxLength) {
            throw InvalidAplicacionException::becauseFieldIsTooLong($field, $maxLength);
        }

        return $normalized;
    }
}
