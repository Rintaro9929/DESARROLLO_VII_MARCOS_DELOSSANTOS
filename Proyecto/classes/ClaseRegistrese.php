<?php

class RegistroUsuario
{
    private $id;
    private $Nombre;
    private $Apellido;
    private $Usuario;
    private $Correo;
    private $secret_2fa;
    private $contrasena;
    private $hasTGenerate;
    private $pdo;
    private $tabla;
    private $FechaSistema;

    public function __construct($datos, $pdo, &$arrMensaje)
    {
        $this->pdo = $pdo;
        $this->tabla = "usuarios";
        $this->FechaSistema = date("Y-m-d H:i:s");

        if (isset($datos["nombre"])) {
            $this->Nombre = SanitizarEntrada::CadTitulo($datos["nombre"]);
        } else {
            $arrMensaje[1] = "No se recibió el campo Nombre";
        }

        if (isset($datos["apellido"])) {
            $this->Apellido = SanitizarEntrada::CadTitulo($datos["apellido"]);
        } else {
            $arrMensaje[2] = "No se recibió el campo Apellido";
        }

        if (isset($datos["usuario"])) {
            $this->Usuario = SanitizarEntrada::limpiarCadena($datos["usuario"]);
        } else {
            $arrMensaje[3] = "No se recibió el campo Usuario";
        }

        if (isset($datos["email1"])) {
            $this->Correo = SanitizarEntrada::limpiarEspacios($datos["email1"]);
            if (!SanitizarEntrada::validarEmail($this->Correo)) {
                $arrMensaje[4] = "Email no válido";
            }
        } else {
            $arrMensaje[4] = "No se recibió el campo Email";
        }

        if (isset($datos["clave"])) {
            $this->contrasena = SanitizarEntrada::limpiarEspacios($datos["clave"]);
        } else {
            $arrMensaje[5] = "No se recibió el campo Contraseña";
        }
    }

    public function encriptClave()
    {
        $options = ['cost' => 13];
        $this->hasTGenerate = password_hash($this->contrasena, PASSWORD_BCRYPT, $options);
        return $this->hasTGenerate;
    }

    public function verificarEmailExistente()
    {
        if ($this->pdo === null || $this->pdo->getConexion() === null) {
            error_log("Error: No hay conexión a la base de datos");
            return false;
        }
        
        $sql = "SELECT COUNT(*) as total FROM usuarios WHERE Correo = :email";
        $stmt = $this->pdo->executeQuery($sql);
        
        if ($stmt === null) {
            error_log("Error: executeQuery devolvió null");
            return false;
        }
        
        $stmt->bindParam(':email', $this->Correo);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        
        return $resultado && $resultado->total > 0;
    }

    public function Guardar_RegistroUsuario()
    {
        $this->encriptClave();

        $data = array(
            "Nombre" => $this->Nombre,
            "Apellido" => $this->Apellido,
            "Usuario" => $this->Usuario,
            "Correo" => $this->Correo,
            "HashMagic" => $this->hasTGenerate,
            "FechaRegistro" => $this->FechaSistema
        );

        $this->id = $this->pdo->insertSeguro($this->tabla, $data);
        return $this->id;
    }

    public function GuardarMySecreto($secreto)
    {
        $dataSecreto = array("secret_2fa" => $secreto);
        $condicion = array("id" => $this->id);

        if ($this->pdo->updateSeguro("usuarios", $dataSecreto, $condicion)) {
            return true;
        }
        return false;
    }

    public function getUsuario()
    {
        return $this->Usuario;
    }

    public function getCorreo()
    {
        return $this->Correo;
    }

    public function getId()
    {
        return $this->id;
    }
}
?>