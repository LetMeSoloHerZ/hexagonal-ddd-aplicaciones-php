<?php

declare(strict_types=1);

/**
 * Datos recibidos desde el formulario web, ya convertidos a tipos simples.
 * Aun no estan validados por el dominio.
 */
final class UpdateAplicacionWebRequest
{
    private string $id;
    private string $nombre;
    private string $proveedor;
    private string $categoria;
    private string $lenguajePrincipal;
    private string $lenguajeSecundario;
    private bool $usaBd;
    private bool $requiereConexionRed;
    private int $numBits;
    private string $sistemaOperativo;
    private string $requisitosHardware;
    private string $licencia;
    private string $precio;
    private string $descripcion;
    private string $web;
    private string $correo;
    private string $tamanoInstalador;

    public function __construct(
        string $id,
        string $nombre,
        string $proveedor,
        string $categoria,
        string $lenguajePrincipal,
        string $lenguajeSecundario,
        bool $usaBd,
        bool $requiereConexionRed,
        int $numBits,
        string $sistemaOperativo,
        string $requisitosHardware,
        string $licencia,
        string $precio,
        string $descripcion,
        string $web,
        string $correo,
        string $tamanoInstalador
    ) {
        $this->id = trim($id);
        $this->nombre = trim($nombre);
        $this->proveedor = trim($proveedor);
        $this->categoria = trim($categoria);
        $this->lenguajePrincipal = trim($lenguajePrincipal);
        $this->lenguajeSecundario = trim($lenguajeSecundario);
        $this->usaBd = $usaBd;
        $this->requiereConexionRed = $requiereConexionRed;
        $this->numBits = $numBits;
        $this->sistemaOperativo = trim($sistemaOperativo);
        $this->requisitosHardware = trim($requisitosHardware);
        $this->licencia = trim($licencia);
        $this->precio = trim($precio);
        $this->descripcion = trim($descripcion);
        $this->web = trim($web);
        $this->correo = trim($correo);
        $this->tamanoInstalador = trim($tamanoInstalador);
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

    public function getLenguajeSecundario(): string
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

    public function getRequisitosHardware(): string
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

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getWeb(): string
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
}
