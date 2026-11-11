<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/AplicacionPersistenceDto.php';
require_once __DIR__ . '/../Entity/AplicacionEntity.php';

require_once __DIR__ . '/../../../../../Domain/Models/AplicacionModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionNombre.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionCorreo.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionWeb.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/Precio.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/TamanoInstalador.php';

/**
 * Data Mapper: traduce entre el modelo de dominio, el DTO de persistencia,
 * la entidad (fila de la tabla) y las filas crudas que devuelve PDO.
 */
final class AplicacionPersistenceMapper
{
    public function fromModelToDto(AplicacionModel $aplicacion): AplicacionPersistenceDto
    {
        return new AplicacionPersistenceDto(
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

    public function fromDtoToEntity(AplicacionPersistenceDto $dto): AplicacionEntity
    {
        return new AplicacionEntity(
            $dto->id(),
            $dto->nombre(),
            $dto->proveedor(),
            $dto->categoria(),
            $dto->lenguajePrincipal(),
            $dto->lenguajeSecundario(),
            $dto->usaBd(),
            $dto->requiereConexionRed(),
            $dto->numBits(),
            $dto->sistemaOperativo(),
            $dto->requisitosHardware(),
            $dto->licencia(),
            $dto->precio(),
            $dto->descripcion(),
            $dto->web(),
            $dto->correo(),
            $dto->tamanoInstalador()
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToEntity(array $row): AplicacionEntity
    {
        return new AplicacionEntity(
            (string) $row['id'],
            (string) $row['nombre'],
            (string) $row['proveedor'],
            (string) $row['categoria'],
            (string) $row['lenguaje_principal'],
            $this->nullableString($row['lenguaje_secundario'] ?? null),
            (bool) (int) $row['usa_bd'],
            (bool) (int) $row['requiere_conexion_red'],
            (int) $row['num_bits'],
            (string) $row['sistema_operativo'],
            $this->nullableString($row['requisitos_hardware'] ?? null),
            (string) $row['licencia'],
            (string) $row['precio'],
            $this->nullableString($row['descripcion'] ?? null),
            $this->nullableString($row['web'] ?? null),
            (string) $row['correo'],
            (string) $row['tamano_instalador_mb'],
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }

    public function fromEntityToModel(AplicacionEntity $entity): AplicacionModel
    {
        return new AplicacionModel(
            new AplicacionId($entity->id()),
            new AplicacionNombre($entity->nombre()),
            $entity->proveedor(),
            $entity->categoria(),
            $entity->lenguajePrincipal(),
            $entity->lenguajeSecundario(),
            $entity->usaBd(),
            $entity->requiereConexionRed(),
            $entity->numBits(),
            $entity->sistemaOperativo(),
            $entity->requisitosHardware(),
            $entity->licencia(),
            new Precio($entity->precio()),
            $entity->descripcion(),
            AplicacionWeb::fromNullable($entity->web()),
            new AplicacionCorreo($entity->correo()),
            new TamanoInstalador($entity->tamanoInstalador())
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    public function fromRowToModel(array $row): AplicacionModel
    {
        return $this->fromEntityToModel(
            $this->fromRowToEntity($row)
        );
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return AplicacionModel[]
     */
    public function fromRowsToModels(array $rows): array
    {
        $models = array();

        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }

        return $models;
    }

    /**
     * @param mixed $value
     */
    private function nullableString($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;

        return $value === '' ? null : $value;
    }
}
