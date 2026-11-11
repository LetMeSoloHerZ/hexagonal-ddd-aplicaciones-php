<?php

declare(strict_types=1);

/**
 * Objeto de transferencia de la capa de persistencia: solo tipos primitivos,
 * listos para enlazarse a una sentencia SQL.
 */
final class AplicacionPersistenceDto
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

    public function id(): string
    {
        return $this->id;
    }

    public function nombre(): string
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

    public function precio(): string
    {
        return $this->precio;
    }

    public function descripcion(): ?string
    {
        return $this->descripcion;
    }

    public function web(): ?string
    {
        return $this->web;
    }

    public function correo(): string
    {
        return $this->correo;
    }

    public function tamanoInstalador(): string
    {
        return $this->tamanoInstalador;
    }
}
