<?php

declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllAplicacionesQuery.php';
require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';

interface GetAllAplicacionesUseCase
{
    /**
     * @return AplicacionModel[]
     */
    public function execute(GetAllAplicacionesQuery $query): array;
}
