<?php
declare(strict_types=1);

class mod_db
{
    private ?\PDO $conexion = null;  // ← Tipo PDO
    private int $perpage = 5;
    private int $total = 0;           // ← Tipo int
    private bool $debug = false;      // ← Tipo bool

    public function __construct()
    {
        $sql_host = "localhost";
        $sql_name = "expedientes";
        $sql_user = "usuario_lab";
        $sql_pass = "password_seguro";

        $dsn = "mysql:host=$sql_host;port=3307;dbname=$sql_name;charset=utf8mb4";
        try {
            $this->conexion = new \PDO($dsn, $sql_user, $sql_pass);
            $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET NAMES utf8mb4");
        } catch (\PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos");
        }
    }

    public function getConexion(): ?\PDO
    {
        return $this->conexion;
    }

    public function disconnect(): void
    {
        $this->conexion = null;
    }

    public function insertSeguro(string $tb_name, array $data): int|false
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO $tb_name ($columns) VALUES ($placeholders)";

        try {
            $stmt = $this->conexion->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            return (int)$this->conexion->lastInsertId();
        } catch (\PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            return false;
        }
    }

    public function updateSeguro(string $tabla, array $data, array $condiciones): bool
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $setSQL = implode(", ", $set);

        $where = [];
        foreach ($condiciones as $key => $value) {
            $where[] = "$key = :cond_$key";
        }
        $whereSQL = implode(" AND ", $where);

        $sql = "UPDATE $tabla SET $setSQL WHERE $whereSQL";

        try {
            $stmt = $this->conexion->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            foreach ($condiciones as $key => $value) {
                $stmt->bindValue(":cond_$key", $value);
            }
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("Error en UPDATE: " . $e->getMessage());
            return false;
        }
    }

    public function log(string $Usuario): ?object
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE Usuario = :User";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':User', $Usuario, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchObject();
        } catch (\PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return null;
        }
    }

    public function executeQuery(string $string): ?\PDOStatement
    {
        try {
            $stmt = $this->conexion->prepare($string);
            $stmt->execute();
            return $stmt;
        } catch (\PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return null;
        }
    }

    public function nums(string $string = "", ?\PDOStatement $stmt = null): int
    {
        if ($string) {
            $stmt = $this->executeQuery($string);
        }
        if ($stmt !== null) {
            $this->total = $stmt->rowCount();
            return $this->total;
        }
        return 0;
    }

    public function objects(?\PDOStatement $stmt = null): ?object
    {
        return $stmt ? $stmt->fetch(\PDO::FETCH_OBJ) : null;
    }

    public function Arreglos(string $string = ""): array
    {
        try {
            if ($string) {
                $stmt = $this->conexion->query($string);
                return $stmt ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : [];
            }
        } catch (\PDOException $e) {
            error_log("Error: " . $e->getMessage());
        }
        return [];
    }
}
?>