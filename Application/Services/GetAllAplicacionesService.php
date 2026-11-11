<?php

declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllAplicacionesUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllAplicacionesPort.php';

final class GetAllAplicacionesService implements GetAllAplicacionesUseCase
{
    private GetAllAplicacionesPort $getAllAplicacionesPort;

    public function __construct(GetAllAplicacionesPort $getAllAplicacionesPort)
    {
        $this->getAllAplicacionesPort = $getAllAplicacionesPort;
    }

    /**
     * @return AplicacionModel[]
     */
    public function execute(GetAllAplicacionesQuery $query): array
    {
        return $this->getAllAplicacionesPort->getAll();
    }
}
