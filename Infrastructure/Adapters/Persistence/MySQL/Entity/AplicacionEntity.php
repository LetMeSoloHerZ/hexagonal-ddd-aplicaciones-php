<?php

declare(strict_types=1);

/**
 * Representa una fila de la tabla `aplicaciones` tal como existe en MySQL.
 */
final class AplicacionEntity
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
    private ?string $createdAt;
    private ?string $updatedAt;

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
        string $tamanoInstalador,
        ?string $createdAt = null,
        ?string $updatedAt = null
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->proveedor = trim($proveedor);
        $this->categoria = trim($categoria);
        $this->lenguajePrincipal = trim($lenguajePrincipal);
        $this->lenguajeSecundario = $lenguajeSecundario;
        $this->usaBd = $usaBd;
        $this->requiereConexionRed = $requiereConexionRed;
        $this->numBits = $numBits;
        $this->sistemaOperativo = trim($sistemaOperativo);
        $this->requisitosHardware = $requisitosHardware;
        $this->licencia = trim($licencia);
        $this->precio = trim($precio);
        $this->descripcion = $descripcion;
        $this->web = $web;
        $this->correo = trim($correo);
        $this->tamanoInstalador = trim($tamanoInstalador);
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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

    public function createdAt(): ?string
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?string
    {
        return $this->updatedAt;
    }
}
