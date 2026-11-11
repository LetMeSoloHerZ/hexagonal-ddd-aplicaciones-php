<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteAplicacionUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteAplicacionPort.php';
require_once __DIR__ . '/../Ports/Out/GetAplicacionByIdPort.php';
require_once __DIR__ . '/Mappers/AplicacionApplicationMapper.php';

require_once __DIR__ . '/../../Domain/Exceptions/AplicacionNotFoundException.php';

final class DeleteAplicacionService implements DeleteAplicacionUseCase
{
    private DeleteAplicacionPort $deleteAplicacionPort;
    private GetAplicacionByIdPort $getAplicacionByIdPort;

    public function __construct(
        DeleteAplicacionPort $deleteAplicacionPort,
        GetAplicacionByIdPort $getAplicacionByIdPort
    ) {
        $this->deleteAplicacionPort = $deleteAplicacionPort;
        $this->getAplicacionByIdPort = $getAplicacionByIdPort;
    }

    public function execute(DeleteAplicacionCommand $command): void
    {
        $id = AplicacionApplicationMapper::fromDeleteCommandToId($command);

        if ($this->getAplicacionByIdPort->getById($id) === null) {
            throw AplicacionNotFoundException::becauseIdWasNotFound($id->value());
        }

        $this->deleteAplicacionPort->delete($id);
    }
}
