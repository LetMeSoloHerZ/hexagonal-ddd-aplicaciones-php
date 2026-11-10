<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateAplicacionCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateAplicacionCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteAplicacionCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetAplicacionByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/AplicacionModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionId.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionNombre.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionCorreo.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/AplicacionWeb.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/Precio.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/TamanoInstalador.php';

/**
 * Capa anticorrupcion: traduce los DTO de la aplicacion (commands/queries)
 * a objetos del dominio, y los modelos del dominio a arreglos simples.
 */
final class AplicacionApplicationMapper
{
    public static function fromCreateCommandToModel(CreateAplicacionCommand $command): AplicacionModel
    {
        return self::buildModel(
            $command->getId(),
            $command->getNombre(),
            $command->getProveedor(),
            $command->getCategoria(),
            $command->getLenguajePrincipal(),
            $command->getLenguajeSecundario(),
            $command->getUsaBd(),
            $command->getRequiereConexionRed(),
            $command->getNumBits(),
            $command->getSistemaOperativo(),
            $command->getRequisitosHardware(),
            $command->getLicencia(),
            $command->getPrecio(),
            $command->getDescripcion(),
            $command->getWeb(),
            $command->getCorreo(),
            $command->getTamanoInstalador()
        );
    }

    public static function fromUpdateCommandToModel(UpdateAplicacionCommand $command): AplicacionModel
    {
        return self::buildModel(
            $command->getId(),
            $command->getNombre(),
            $command->getProveedor(),
            $command->getCategoria(),
            $command->getLenguajePrincipal(),
            $command->getLenguajeSecundario(),
            $command->getUsaBd(),
            $command->getRequiereConexionRed(),
            $command->getNumBits(),
            $command->getSistemaOperativo(),
            $command->getRequisitosHardware(),
            $command->getLicencia(),
            $command->getPrecio(),
            $command->getDescripcion(),
            $command->getWeb(),
            $command->getCorreo(),
            $command->getTamanoInstalador()
        );
    }

    public static function fromGetByIdQueryToId(GetAplicacionByIdQuery $query): AplicacionId
    {
        return new AplicacionId($query->getId());
    }

    public static function fromDeleteCommandToId(DeleteAplicacionCommand $command): AplicacionId
    {
        return new AplicacionId($command->getId());
    }

    /**
     * @return array<string, mixed>
     */
    public static function fromModelToArray(AplicacionModel $aplicacion): array
    {
        return $aplicacion->toArray();
    }

    /**
     * @param AplicacionModel[] $aplicaciones
     * @return array<int, array<string, mixed>>
     */
    public static function fromModelsToArray(array $aplicaciones): array
    {
        $result = array();

        foreach ($aplicaciones as $aplicacion) {
            $result[] = self::fromModelToArray($aplicacion);
        }

        return $result;
    }

    private static function buildModel(
        string $id,
        string $nombre,
        string $proveedor,
        string $categoria,
        string $lenguajePrincipal,
        string $lenguajeSecundario,
        bool $usaBd,
        bool $requiereConexionRed,
        int $numBits,
        string $sistemaOperativo,
        string $requisitosHardware,
        string $licencia,
        string $precio,
        string $descripcion,
        string $web,
        string $correo,
        string $tamanoInstalador
    ): AplicacionModel {
        return AplicacionModel::create(
            new AplicacionId($id),
            new AplicacionNombre($nombre),
            $proveedor,
            $categoria,
            $lenguajePrincipal,
            self::emptyToNull($lenguajeSecundario),
            $usaBd,
            $requiereConexionRed,
            $numBits,
            $sistemaOperativo,
            self::emptyToNull($requisitosHardware),
            $licencia,
            new Precio($precio),
            self::emptyToNull($descripcion),
            AplicacionWeb::fromNullable($web),
            new AplicacionCorreo($correo),
            new TamanoInstalador($tamanoInstalador)
        );
    }

    private static function emptyToNull(string $value): ?string
    {
        $value = trim($value);

        return $value === '' ? null : $value;
    }
}
