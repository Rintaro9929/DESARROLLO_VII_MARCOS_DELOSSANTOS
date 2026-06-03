<?php

class mod_db
{
    private $conexion;
    private $perpage = 5;
    private $total;
    private $debug = false;

    public function __construct()
    {
        $sql_host = "localhost";
        $sql_name = "expedientes";
        $sql_user = "usuario_lab";
        $sql_pass = "password_seguro";

        $dsn = "mysql:host=$sql_host;port=3307;dbname=$sql_name;charset=utf8mb4";
        
        try {
            $this->conexion = new PDO($dsn, $sql_user, $sql_pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->exec("SET NAMES utf8mb4");
            if ($this->debug) {
                echo "Conexión exitosa a la base de datos<br>";
            }
        } catch (PDOException $e) {
            error_log("Error de conexión: " . $e->getMessage());
            die("Error de conexión a la base de datos");
        }
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function disconnect()
    {
        $this->conexion = null;
    }

    public function insertSeguro($tb_name, $data)
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
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error en INSERT: " . $e->getMessage());
            return false;
        }
    }

    public function updateSeguro($tabla, $data, $condiciones)
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
        } catch (PDOException $e) {
            error_log("Error en UPDATE: " . $e->getMessage());
            return false;
        }
    }

    public function log($Usuario)
    {
        try {
            $sql = "SELECT * FROM usuarios WHERE Usuario = :User";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':User', $Usuario, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchObject();
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return null;
        }
    }

    public function executeQuery($string)
    {
        if ($this->conexion === null) {
            error_log("executeQuery: conexión es null");
            return null;
        }
        
        try {
            $stmt = $this->conexion->prepare($string);
            if ($stmt === false) {
                error_log("executeQuery: prepare falló para: " . $string);
                return null;
            }
            return $stmt;
        } catch (PDOException $e) {
            error_log("executeQuery Exception: " . $e->getMessage());
            return null;
        }
    }

    public function nums($string = "", $stmt = null)
    {
        if ($string) {
            $stmt = $this->executeQuery($string);
        }
        if ($stmt != null) {
            $this->total = $stmt ? $stmt->rowCount() : 0;
            return $this->total;
        } else {
            return 0;
        }
    }

    public function objects($stmt = null)
    {
        return $stmt ? $stmt->fetch(PDO::FETCH_OBJ) : null;
    }

    public function Arreglos($string = "")
    {
        try {
            if ($string) {
                $stmt = $this->conexion->query($string);
                return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
            }
        } catch (PDOException $e) {
            error_log("Error en Arreglos: " . $e->getMessage());
        }
        return [];
    }
}
?>