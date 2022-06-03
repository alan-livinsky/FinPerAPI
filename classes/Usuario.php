<?php

 // Clase de Usuario

class Usuario
{
    private $idUsuario;
    private $nombre; 
    private $email; 
    private $contrasena;

    public function __construct($usu_id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = "SELECT * FROM `usuarios` WHERE `usu_id` = '$usu_id'";
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->execute();

		if($consulta->rowCount() > 0){
			while($usr = $consulta->fetch(PDO::FETCH_ASSOC)){
                $this->idUsuario = $usr['usu_id'];
                $this->nombre = $usr['usu_nombre'];
                $this->email = $usr['usu_email'];
                $this->contrasena = $usr['usu_contrasena'];
            }
    	}
    }

    public function validaLogin($usu_id, $usu_contrasena)
    {
        $estado = 'No existe';
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = "SELECT usu_contrasena FROM `fp_usuarios` WHERE `usu_id` = '$usu_id'";
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->execute();

        if($consulta->rowCount() > 0){
            while($usr = $consulta->fetch(PDO::FETCH_ASSOC)){
                if($usr['usu_contrasena'] === $usu_contrasena)
                {
                    $estado = 'Acceso correcto';
                }
                else{
                    $estado = 'Contraseña incorrecta';
                }
            }
    	}else{
            $estado = 'No existe';
        }
        return $estado;
    }

    public function registraUsuario($data)
    {
        $data['nombre'];
        $contraseña = sha1($contraseña);
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $sql = "INSERT INTO `usuarios`(`usu_id`, `usu_nombre`, `usu_email`, `usu_fnacimiento`, `usu_idresidencia`, `usu_idcontrasena`, `usu_estado`, `usu_contador`, `usu_fultintento`, `usu_idperfil`) VALUES (null,'$data['nombre'];','$mail','$fnacimiento','$residencia','$contraseña',1,0,0,1)";
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->execute();

        $sql = "SELECT id FROM USUARIOS WHERE usu_idcontrasena = '$contraseña'";
        $consulta = $objetoAccesoDato->RetornarConsulta($sql);
        $consulta->execute();

        if($consulta->rowCount() > 0){
            while($usr = $consulta->fetch(PDO::FETCH_ASSOC)){
                $id = $usr['usu_id'];
            }

            $token = generaToken();
    
            $sql = "INSERT INTO `validaciones_credenciales`(`vcre_id`, `vcre_idusuario`, `vcre_token`) VALUES (null,'$id','$token')";
            $consulta = $objetoAccesoDato->RetornarConsulta($sql);
            $consulta->execute();
    
            return $token;
        }

        return 'error';

    }

    public function generaToken(){
        $token = str_shuffle("AaBbCcDdFfGgHhJjKkLlMmNNOoPpQqRrSsTtUuVvWwXxYyZz");
        $token = sha1($token);

        return $token;
    }
    
}