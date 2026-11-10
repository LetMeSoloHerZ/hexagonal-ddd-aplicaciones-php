<?php

declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveAplicacionPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateAplicacionPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAplicacionByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAplicacionByNombrePort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllAplicacionesPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteAplicacionPort.php';

require_once __DIR__ . '/../Mapper/AplicacionPersistenceMapper.php';
require_once __DIR__ . '/../../../../../Domain/Models/AplicacionModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/AplicacionNombre.php';

/**
 * Adaptador de salida: implementa los puertos de persistencia con PDO
 * y sentencias preparadas sobre MySQL.
 */
final class AplicacionRepositoryMySQL implements
    SaveAplicacionPort,
    UpdateAplicacionPort,
    GetAplicacionByIdPort,
    GetAplicacionByNombrePort,
    GetAllAplicacionesPort,
    DeleteAplicacionPort
{
    private const SELECT_COLUMNS = '
        id,
        nombre,
        proveedor,
        categoria,
        lenguaje_principal,
        lenguaje_secundario,
        usa_bd,
        requiere_conexion_red,
        num_bits,
        sistema_operativo,
        requisitos_hardware,
        licencia,
        precio,
        descripcion,
        web,
        correo,
        tamano_instalador_mb,
        created_at,
        updated_at
    ';

    private PDO $pdo;
    private AplicacionPersistenceMapper $mapper;

    public function __construct(PDO $pdo, AplicacionPersistenceMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(AplicacionModel $aplicacion): AplicacionModel
    {
        $dto = $this->mapper->fromModelToDto($aplicacion);

        $sql = '
            INSERT INTO aplicaciones (
                id,
                nombre,
                proveedor,
                categoria,
                lenguaje_principal,
                lenguaje_secundario,
                usa_bd,
                requiere_conexion_red,
                num_bits,
                sistema_operativo,
                requisitos_hardware,
                licencia,
                precio,
                descripcion,
                web,
                correo,
                tamano_instalador_mb
            ) VALUES (
                :id,
                :nombre,
                :proveedor,
                :categoria,
                :lenguaje_principal,
                :lenguaje_secundario,
                :usa_bd,
                :requiere_conexion_red,
                :num_bits,
                :sistema_operativo,
                :requisitos_hardware,
                :licencia,
                :precio,
                :descripcion,
                :web,
                :correo,
                :tamano_instalador_mb
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($this->parameters($dto));

        $saved = $this->getById(new AplicacionId($dto->id()));

        if ($saved === null) {
            throw new RuntimeException('The application could not be recovered after save.');
        }

        return $saved;
    }

    public function update(AplicacionModel $aplicacion): AplicacionModel
    {
        $dto = $this->mapper->fromModelToDto($aplicacion);

        $sql = '
            UPDATE aplicaciones
               SET nombre = :nombre,
                   proveedor = :proveedor,
                   categoria = :categoria,
                   lenguaje_principal = :lenguaje_principal,
                   lenguaje_secundario = :lenguaje_secundario,
                   usa_bd = :usa_bd,
                   requiere_conexion_red = :requiere_conexion_red,
                   num_bits = :num_bits,
                   sistema_operativo = :sistema_operativo,
                   requisitos_hardware = :requisitos_hardware,
                   licencia = :licencia,
                   precio = :precio,
                   descripcion = :descripcion,
                   web = :web,
                   correo = :correo,
                   tamano_instalador_mb = :tamano_instalador_mb,
                   updated_at = NOW()
             WHERE id = :id
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($this->parameters($dto));

        $updated = $this->getById(new AplicacionId($dto->id()));

        if ($updated === null) {
            throw new RuntimeException('The application could not be recovered after update.');
        }

        return $updated;
    }

    public function getById(AplicacionId $id): ?AplicacionModel
    {
        $sql = 'SELECT ' . self::SELECT_COLUMNS . ' FROM aplicaciones WHERE id = :id LIMIT 1';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id->value()));

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    public function getByNombre(AplicacionNombre $nombre): ?AplicacionModel
    {
        $sql = 'SELECT ' . self::SELECT_COLUMNS . ' FROM aplicaciones WHERE nombre = :nombre LIMIT 1';

        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':nombre' => $nombre->value()));

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    /**
     * @return AplicacionModel[]
     */
    public function getAll(): array
    {
        $sql = 'SELECT ' . self::SELECT_COLUMNS . ' FROM aplicaciones ORDER BY nombre ASC';

        $statement = $this->pdo->query($sql);
        $rows = $statement->fetchAll();

        return $this->mapper->fromRowsToModels($rows);
    }

    public function delete(AplicacionId $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM aplicaciones WHERE id = :id');
        $statement->execute(array(':id' => $id->value()));
    }

    /**
     * @return array<string, mixed>
     */
    private function parameters(AplicacionPersistenceDto $dto): array
    {
        return array(
            ':id' => $dto->id(),
            ':nombre' => $dto->nombre(),
            ':proveedor' => $dto->proveedor(),
            ':categoria' => $dto->categoria(),
            ':lenguaje_principal' => $dto->lenguajePrincipal(),
            ':lenguaje_secundario' => $dto->lenguajeSecundario(),
            ':usa_bd' => $dto->usaBd() ? 1 : 0,
            ':requiere_conexion_red' => $dto->requiereConexionRed() ? 1 : 0,
            ':num_bits' => $dto->numBits(),
            ':sistema_operativo' => $dto->sistemaOperativo(),
            ':requisitos_hardware' => $dto->requisitosHardware(),
            ':licencia' => $dto->licencia(),
            ':precio' => $dto->precio(),
            ':descripcion' => $dto->descripcion(),
            ':web' => $dto->web(),
            ':correo' => $dto->correo(),
            ':tamano_instalador_mb' => $dto->tamanoInstalador(),
        );
    }
}
