<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAplicacionByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface GetAplicacionByIdUseCase
{
    public function execute(GetAplicacionByIdQuery $query): AplicacionModel;
}
