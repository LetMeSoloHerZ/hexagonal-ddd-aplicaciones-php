<?php

declare(strict_types=1);

/**
 * Datos de una aplicacion listos para mostrarse en las vistas.
 */
final class AplicacionResponse
{
    private string $id;
    private string $nombre;
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
    private string $precio;
    private ?string $descripcion;
    private ?string $web;
    private string $correo;
    private string $tamanoInstalador;

    public function __construct(
        string $id,
        string $nombre,
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
        string $precio,
        ?string $descripcion,
        ?string $web,
        string $correo,
        string $tamanoInstalador
    ) {
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

    public function getId(): string
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getProveedor(): string
    {
        return $this->proveedor;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getLenguajePrincipal(): string
    {
        return $this->lenguajePrincipal;
    }

    public function getLenguajeSecundario(): ?string
    {
        return $this->lenguajeSecundario;
    }

    public function getUsaBd(): bool
    {
        return $this->usaBd;
    }

    public function getRequiereConexionRed(): bool
    {
        return $this->requiereConexionRed;
    }

    public function getNumBits(): int
    {
        return $this->numBits;
    }

    public function getSistemaOperativo(): string
    {
        return $this->sistemaOperativo;
    }

    public function getRequisitosHardware(): ?string
    {
        return $this->requisitosHardware;
    }

    public function getLicencia(): string
    {
        return $this->licencia;
    }

    public function getPrecio(): string
    {
        return $this->precio;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function getTamanoInstalador(): string
    {
        return $this->tamanoInstalador;
    }

    /**
     * Valores en el formato que usa el formulario HTML (cadenas; casillas como '1' o '0').
     *
     * @return array<string, string>
     */
    public function toFormValues(): array
    {
        return array(
            'id' => $this->id,
            'nombre' => $this->nombre,
            'proveedor' => $this->proveedor,
            'categoria' => $this->categoria,
            'lenguajePrincipal' => $this->lenguajePrincipal,
            'lenguajeSecundario' => (string) $this->lenguajeSecundario,
            'usaBd' => $this->usaBd ? '1' : '0',
            'requiereConexionRed' => $this->requiereConexionRed ? '1' : '0',
            'numBits' => (string) $this->numBits,
            'sistemaOperativo' => $this->sistemaOperativo,
            'requisitosHardware' => (string) $this->requisitosHardware,
            'licencia' => $this->licencia,
            'precio' => $this->precio,
            'descripcion' => (string) $this->descripcion,
            'web' => (string) $this->web,
            'correo' => $this->correo,
            'tamanoInstalador' => $this->tamanoInstalador,
        );
    }
}
