<?php

declare(strict_types=1);

final class Connection
{
    /** Bundle de certificados raiz del sistema en Debian/Ubuntu (imagen Docker y CI). */
    private const SYSTEM_CA_BUNDLE = '/etc/ssl/certs/ca-certificates.crt';

    private string $host;
    private int $port;
    private string $database;
    private string $username;
    private string $password;
    private string $charset;
    private bool $ssl;
    private string $sslCa;
    private bool $sslVerify;

    public function __construct(
        string $host,
        int $port,
        string $database,
        string $username,
        string $password,
        string $charset = 'utf8mb4',
        bool $ssl = false,
        string $sslCa = '',
        bool $sslVerify = true
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $this->ssl = $ssl;
        $this->sslCa = $sslCa;
        $this->sslVerify = $sslVerify;
    }

    public function createPdo(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $this->host,
            $this->port,
            $this->database,
            $this->charset
        );

        return new PDO($dsn, $this->username, $this->password, $this->buildOptions());
    }

    /**
     * Opciones PDO. Si ssl esta activo (bases en la nube como TiDB Cloud o Aiven)
     * se fuerza la conexion cifrada; sin ssl el comportamiento es el de siempre.
     */
    public function buildOptions(): array
    {
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        );

        if (!$this->ssl) {
            return $options;
        }

        $ca = $this->sslCa;
        if ($ca === '' && is_file(self::SYSTEM_CA_BUNDLE)) {
            $ca = self::SYSTEM_CA_BUNDLE;
        }

        // Con mysqlnd, definir el CA es lo que activa TLS en el cliente.
        if ($ca !== '') {
            $options[PDO::MYSQL_ATTR_SSL_CA] = $ca;
        }
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = $this->sslVerify;

        return $options;
    }
}
