<?php

declare(strict_types=1);

final class ClassLoader
{
    /**
     * @var array<string, string>
     */
    private static array $classMap = array(
        'InvalidUserEmailException' => 'Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException' => 'Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException' => 'Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException' => 'Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException' => 'Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException' => 'Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException' => 'Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException' => 'Domain/Exceptions/InvalidCredentialsException.php',

        'UserRoleEnum' => 'Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum' => 'Domain/Enums/UserStatusEnum.php',

        'UserId' => 'Domain/ValueObjects/UserId.php',
        'UserName' => 'Domain/ValueObjects/UserName.php',
        'UserEmail' => 'Domain/ValueObjects/UserEmail.php',
        'UserPassword' => 'Domain/ValueObjects/UserPassword.php',

        'UserModel' => 'Domain/Models/UserModel.php',
        'EmailDestinationModel' => 'Domain/Models/EmailDestinationModel.php',
        'EmailSenderException' => 'Domain/Exceptions/EmailSenderException.php',
        'EmailSenderPort' => 'Application/Ports/Out/EmailSenderPort.php',
        'EmailNotificationService' => 'Application/Services/EmailNotificationService.php',
        'EmailSenderService' => 'Infrastructure/Adapters/Email/EmailSenderService.php',

        'CreateUserUseCase' => 'Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase' => 'Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase' => 'Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase' => 'Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase' => 'Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase' => 'Application/Ports/In/LoginUseCase.php',

        'SaveUserPort' => 'Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort' => 'Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort' => 'Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort' => 'Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort' => 'Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort' => 'Application/Ports/Out/DeleteUserPort.php',

        'CreateUserCommand' => 'Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand' => 'Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand' => 'Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand' => 'Application/Services/Dto/Commands/LoginCommand.php',
        'GetUserByIdQuery' => 'Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery' => 'Application/Services/Dto/Queries/GetAllUsersQuery.php',

        'CreateUserService' => 'Application/Services/CreateUserService.php',
        'UpdateUserService' => 'Application/Services/UpdateUserService.php',
        'GetUserByIdService' => 'Application/Services/GetUserByIdService.php',
        'GetAllUsersService' => 'Application/Services/GetAllUsersService.php',
        'DeleteUserService' => 'Application/Services/DeleteUserService.php',
        'LoginService' => 'Application/Services/LoginService.php',
        'UserApplicationMapper' => 'Application/Services/Mappers/UserApplicationMapper.php',

        'Connection' => 'Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',

        'CreateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse' => 'Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper' => 'Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController' => 'Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'WebRoutes' => 'Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',

        'View' => 'Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash' => 'Infrastructure/Entrypoints/Web/Presentation/Flash.php',

        // ---- Aplicacion (ejercicio 21) ----
        'InvalidAplicacionException' => 'Domain/Exceptions/InvalidAplicacionException.php',
        'AplicacionNotFoundException' => 'Domain/Exceptions/AplicacionNotFoundException.php',
        'AplicacionAlreadyExistsException' => 'Domain/Exceptions/AplicacionAlreadyExistsException.php',

        'CategoriaAplicacionEnum' => 'Domain/Enums/CategoriaAplicacionEnum.php',
        'SistemaOperativoEnum' => 'Domain/Enums/SistemaOperativoEnum.php',
        'LicenciaEnum' => 'Domain/Enums/LicenciaEnum.php',

        'AplicacionId' => 'Domain/ValueObjects/AplicacionId.php',
        'AplicacionNombre' => 'Domain/ValueObjects/AplicacionNombre.php',
        'AplicacionCorreo' => 'Domain/ValueObjects/AplicacionCorreo.php',
        'AplicacionWeb' => 'Domain/ValueObjects/AplicacionWeb.php',
        'Precio' => 'Domain/ValueObjects/Precio.php',
        'TamanoInstalador' => 'Domain/ValueObjects/TamanoInstalador.php',
        'AplicacionModel' => 'Domain/Models/AplicacionModel.php',

        'SaveAplicacionPort' => 'Application/Ports/Out/SaveAplicacionPort.php',
        'UpdateAplicacionPort' => 'Application/Ports/Out/UpdateAplicacionPort.php',
        'GetAplicacionByIdPort' => 'Application/Ports/Out/GetAplicacionByIdPort.php',
        'GetAplicacionByNombrePort' => 'Application/Ports/Out/GetAplicacionByNombrePort.php',
        'GetAllAplicacionesPort' => 'Application/Ports/Out/GetAllAplicacionesPort.php',
        'DeleteAplicacionPort' => 'Application/Ports/Out/DeleteAplicacionPort.php',

        'CreateAplicacionUseCase' => 'Application/Ports/In/CreateAplicacionUseCase.php',
        'UpdateAplicacionUseCase' => 'Application/Ports/In/UpdateAplicacionUseCase.php',
        'GetAplicacionByIdUseCase' => 'Application/Ports/In/GetAplicacionByIdUseCase.php',
        'GetAllAplicacionesUseCase' => 'Application/Ports/In/GetAllAplicacionesUseCase.php',
        'DeleteAplicacionUseCase' => 'Application/Ports/In/DeleteAplicacionUseCase.php',

        'CreateAplicacionCommand' => 'Application/Services/Dto/Commands/CreateAplicacionCommand.php',
        'UpdateAplicacionCommand' => 'Application/Services/Dto/Commands/UpdateAplicacionCommand.php',
        'DeleteAplicacionCommand' => 'Application/Services/Dto/Commands/DeleteAplicacionCommand.php',
        'GetAplicacionByIdQuery' => 'Application/Services/Dto/Queries/GetAplicacionByIdQuery.php',
        'GetAllAplicacionesQuery' => 'Application/Services/Dto/Queries/GetAllAplicacionesQuery.php',

        'CreateAplicacionService' => 'Application/Services/CreateAplicacionService.php',
        'UpdateAplicacionService' => 'Application/Services/UpdateAplicacionService.php',
        'GetAplicacionByIdService' => 'Application/Services/GetAplicacionByIdService.php',
        'GetAllAplicacionesService' => 'Application/Services/GetAllAplicacionesService.php',
        'DeleteAplicacionService' => 'Application/Services/DeleteAplicacionService.php',
        'AplicacionApplicationMapper' => 'Application/Services/Mappers/AplicacionApplicationMapper.php',

        'AplicacionPersistenceDto' => 'Infrastructure/Adapters/Persistence/MySQL/Dto/AplicacionPersistenceDto.php',
        'AplicacionEntity' => 'Infrastructure/Adapters/Persistence/MySQL/Entity/AplicacionEntity.php',
        'AplicacionPersistenceMapper' => 'Infrastructure/Adapters/Persistence/MySQL/Mapper/AplicacionPersistenceMapper.php',
        'AplicacionRepositoryMySQL' => 'Infrastructure/Adapters/Persistence/MySQL/Repository/AplicacionRepositoryMySQL.php',

        'DependencyInjection' => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }

        $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];

        if (!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf('No se encontró el archivo para la clase %s en %s', $className, $filePath)
            );
        }

        require_once $filePath;
    }
}