<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionNombre.php';

interface GetAplicacionByNombrePort
{
    public function getByNombre(AplicacionNombre $nombre): ?AplicacionModel;
}
