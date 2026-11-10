<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionId.php';

interface GetAplicacionByIdPort
{
    public function getById(AplicacionId $id): ?AplicacionModel;
}
