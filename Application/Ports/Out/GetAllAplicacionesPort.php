<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface GetAllAplicacionesPort
{
    /**
     * @return AplicacionModel[]
     */
    public function getAll(): array;
}
