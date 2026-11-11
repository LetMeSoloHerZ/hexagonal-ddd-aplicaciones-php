<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAplicacionByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAplicacionByIdPort.php';
require_once __DIR__ . '/Mappers/AplicacionApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/AplicacionNotFoundException.php';

final class GetAplicacionByIdService implements GetAplicacionByIdUseCase
{
    private GetAplicacionByIdPort $getAplicacionByIdPort;

    public function __construct(GetAplicacionByIdPort $getAplicacionByIdPort)
    {
        $this->getAplicacionByIdPort = $getAplicacionByIdPort;
    }

    public function execute(GetAplicacionByIdQuery $query): AplicacionModel
    {
        $id = AplicacionApplicationMapper::fromGetByIdQueryToId($query);
        $aplicacion = $this->getAplicacionByIdPort->getById($id);

        if ($aplicacion === null) {
            throw AplicacionNotFoundException::becauseIdWasNotFound($id->value());
        }

        return $aplicacion;
    }
}
