<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateAplicacionRequest.php';
require_once __DIR__ . '/../Dto/UpdateAplicacionRequest.php';
require_once __DIR__ . '/../Dto/AplicacionResponse.php';

require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateAplicacionCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateAplicacionCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteAplicacionCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetAplicacionByIdQuery.php';

require_once __DIR__ . '/../../../../../Domain/Models/AplicacionModel.php';

/**
 * Traduce entre los DTO de la capa web (requests/responses)
 * y los commands/queries de la capa de aplicacion.
 */
final class AplicacionWebMapper
{
    public function fromCreateRequestToCommand(CreateAplicacionWebRequest $request): CreateAplicacionCommand
    {
        return new CreateAplicacionCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getProveedor(),
            $request->getCategoria(),
            $request->getLenguajePrincipal(),
            $request->getLenguajeSecundario(),
            $request->getUsaBd(),
            $request->getRequiereConexionRed(),
            $request->getNumBits(),
            $request->getSistemaOperativo(),
            $request->getRequisitosHardware(),
            $request->getLicencia(),
            $request->getPrecio(),
            $request->getDescripcion(),
            $request->getWeb(),
            $request->getCorreo(),
            $request->getTamanoInstalador()
        );
    }

    public function fromUpdateRequestToCommand(UpdateAplicacionWebRequest $request): UpdateAplicacionCommand
    {
        return new UpdateAplicacionCommand(
            $request->getId(),
            $request->getNombre(),
            $request->getProveedor(),
            $request->getCategoria(),
            $request->getLenguajePrincipal(),
            $request->getLenguajeSecundario(),
            $request->getUsaBd(),
            $request->getRequiereConexionRed(),
            $request->getNumBits(),
            $request->getSistemaOperativo(),
            $request->getRequisitosHardware(),
            $request->getLicencia(),
            $request->getPrecio(),
            $request->getDescripcion(),
            $request->getWeb(),
            $request->getCorreo(),
            $request->getTamanoInstalador()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetAplicacionByIdQuery
    {
        return new GetAplicacionByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteAplicacionCommand
    {
        return new DeleteAplicacionCommand($id);
    }

    public function fromModelToResponse(AplicacionModel $aplicacion): AplicacionResponse
    {
        return new AplicacionResponse(
            $aplicacion->id()->value(),
            $aplicacion->nombre()->value(),
            $aplicacion->proveedor(),
            $aplicacion->categoria(),
            $aplicacion->lenguajePrincipal(),
            $aplicacion->lenguajeSecundario(),
            $aplicacion->usaBd(),
            $aplicacion->requiereConexionRed(),
            $aplicacion->numBits(),
            $aplicacion->sistemaOperativo(),
            $aplicacion->requisitosHardware(),
            $aplicacion->licencia(),
            (string) $aplicacion->precio(),
            $aplicacion->descripcion(),
            $aplicacion->web() === null ? null : $aplicacion->web()->value(),
            $aplicacion->correo()->value(),
            number_format($aplicacion->tamanoInstalador()->value(), 2, '.', '')
        );
    }

    /**
     * @param AplicacionModel[] $aplicaciones
     * @return AplicacionResponse[]
     */
    public function fromModelsToResponses(array $aplicaciones): array
    {
        $responses = array();

        foreach ($aplicaciones as $aplicacion) {
            $responses[] = $this->fromModelToResponse($aplicacion);
        }

        return $responses;
    }
}
