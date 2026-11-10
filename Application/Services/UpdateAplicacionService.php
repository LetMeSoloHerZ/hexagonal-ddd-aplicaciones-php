<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateAplicacionUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateAplicacionPort.php';
require_once __DIR__ . '/../Ports/Out/GetAplicacionByIdPort.php';
require_once __DIR__ . '/../Ports/Out/GetAplicacionByNombrePort.php';
require_once __DIR__ . '/Mappers/AplicacionApplicationMapper.php';

require_once __DIR__ . '/../../Domain/Exceptions/AplicacionNotFoundException.php';
require_once __DIR__ . '/../../Domain/Exceptions/AplicacionAlreadyExistsException.php';

final class UpdateAplicacionService implements UpdateAplicacionUseCase
{
    private UpdateAplicacionPort $updateAplicacionPort;
    private GetAplicacionByIdPort $getAplicacionByIdPort;
    private GetAplicacionByNombrePort $getAplicacionByNombrePort;

    public function __construct(
        UpdateAplicacionPort $updateAplicacionPort,
        GetAplicacionByIdPort $getAplicacionByIdPort,
        GetAplicacionByNombrePort $getAplicacionByNombrePort
    ) {
        $this->updateAplicacionPort = $updateAplicacionPort;
        $this->getAplicacionByIdPort = $getAplicacionByIdPort;
        $this->getAplicacionByNombrePort = $getAplicacionByNombrePort;
    }

    public function execute(UpdateAplicacionCommand $command): AplicacionModel
    {
        $aplicacion = AplicacionApplicationMapper::fromUpdateCommandToModel($command);

        $current = $this->getAplicacionByIdPort->getById($aplicacion->id());

        if ($current === null) {
            throw AplicacionNotFoundException::becauseIdWasNotFound($aplicacion->id()->value());
        }

        $sameName = $this->getAplicacionByNombrePort->getByNombre($aplicacion->nombre());

        if ($sameName !== null && !$sameName->id()->equals($aplicacion->id())) {
            throw AplicacionAlreadyExistsException::becauseNameAlreadyExists($aplicacion->nombre()->value());
        }

        return $this->updateAplicacionPort->update($aplicacion);
    }
}
