<?php

declare(strict_types=1);

require_once __DIR__ . '/Mapper/AplicacionWebMapper.php';

require_once __DIR__ . '/../../../../Application/Ports/In/CreateAplicacionUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateAplicacionUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAplicacionByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllAplicacionesUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteAplicacionUseCase.php';

require_once __DIR__ . '/../../../../Application/Services/Dto/Queries/GetAllAplicacionesQuery.php';

/**
 * Adaptador de entrada (web): recibe requests, invoca los casos de uso
 * y devuelve responses. No contiene logica de negocio.
 */
final class AplicacionController
{
    private CreateAplicacionUseCase $createAplicacionUseCase;
    private UpdateAplicacionUseCase $updateAplicacionUseCase;
    private GetAplicacionByIdUseCase $getAplicacionByIdUseCase;
    private GetAllAplicacionesUseCase $getAllAplicacionesUseCase;
    private DeleteAplicacionUseCase $deleteAplicacionUseCase;
    private AplicacionWebMapper $mapper;

    public function __construct(
        CreateAplicacionUseCase $createAplicacionUseCase,
        UpdateAplicacionUseCase $updateAplicacionUseCase,
        GetAplicacionByIdUseCase $getAplicacionByIdUseCase,
        GetAllAplicacionesUseCase $getAllAplicacionesUseCase,
        DeleteAplicacionUseCase $deleteAplicacionUseCase,
        AplicacionWebMapper $mapper
    ) {
        $this->createAplicacionUseCase = $createAplicacionUseCase;
        $this->updateAplicacionUseCase = $updateAplicacionUseCase;
        $this->getAplicacionByIdUseCase = $getAplicacionByIdUseCase;
        $this->getAllAplicacionesUseCase = $getAllAplicacionesUseCase;
        $this->deleteAplicacionUseCase = $deleteAplicacionUseCase;
        $this->mapper = $mapper;
    }

    /**
     * @return AplicacionResponse[]
     */
    public function index(): array
    {
        $aplicaciones = $this->getAllAplicacionesUseCase->execute(new GetAllAplicacionesQuery());

        return $this->mapper->fromModelsToResponses($aplicaciones);
    }

    public function show(string $id): AplicacionResponse
    {
        $query = $this->mapper->fromIdToGetByIdQuery($id);
        $aplicacion = $this->getAplicacionByIdUseCase->execute($query);

        return $this->mapper->fromModelToResponse($aplicacion);
    }

    public function store(CreateAplicacionWebRequest $request): AplicacionResponse
    {
        $command = $this->mapper->fromCreateRequestToCommand($request);
        $aplicacion = $this->createAplicacionUseCase->execute($command);

        return $this->mapper->fromModelToResponse($aplicacion);
    }

    public function update(UpdateAplicacionWebRequest $request): AplicacionResponse
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);
        $aplicacion = $this->updateAplicacionUseCase->execute($command);

        return $this->mapper->fromModelToResponse($aplicacion);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteAplicacionUseCase->execute($command);
    }
}
