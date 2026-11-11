<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateAplicacionUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveAplicacionPort.php';
require_once __DIR__ . '/../Ports/Out/GetAplicacionByNombrePort.php';
require_once __DIR__ . '/Mappers/AplicacionApplicationMapper.php';

require_once __DIR__ . '/../../Domain/Exceptions/AplicacionAlreadyExistsException.php';

final class CreateAplicacionService implements CreateAplicacionUseCase
{
    private SaveAplicacionPort $saveAplicacionPort;
    private GetAplicacionByNombrePort $getAplicacionByNombrePort;

    public function __construct(
        SaveAplicacionPort $saveAplicacionPort,
        GetAplicacionByNombrePort $getAplicacionByNombrePort
    ) {
        $this->saveAplicacionPort = $saveAplicacionPort;
        $this->getAplicacionByNombrePort = $getAplicacionByNombrePort;
    }

    public function execute(CreateAplicacionCommand $command): AplicacionModel
    {
        // Fail-fast: primero se validan los datos (el dominio lanza excepciones).
        $aplicacion = AplicacionApplicationMapper::fromCreateCommandToModel($command);

        $existing = $this->getAplicacionByNombrePort->getByNombre($aplicacion->nombre());

        if ($existing !== null) {
            throw AplicacionAlreadyExistsException::becauseNameAlreadyExists($aplicacion->nombre()->value());
        }

        return $this->saveAplicacionPort->save($aplicacion);
    }
}
