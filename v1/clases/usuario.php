<?php
class usuario
{
	public $id;
    public $nombre;
    public $mail;
    public $fNacimiento;
    public $residencia;
    public $token;
    public $tokenExp;
    public $profesion;
    public $modoIngreso;
    public $password;

	public function ValidaUsuario()
	{
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			$sql = "SELECT usu_contrasena, usu_nombre, usu_id FROM `usuarios` WHERE `usu_email` = '$this->mail'";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$usuario = $resultado->fetch(PDO::FETCH_ASSOC);

				if($usuario['usu_contrasena'] == $this->password){
					$this->nombre = $usuario['usu_nombre'];
					$this->id = $usuario['usu_id'];
					return true;
				}else{
					return false;
				}
			}else{
				echo json_encode("No existe el correo en la BBDD: " . $this->mail);
				return false;
			}


		}
		catch (PDOException $e)
		{

		}
	}

	public function UpdateToken()
	{
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			// Inicia transacción
			$db->beginTransaction();

			// Borrá lógicamente un usuario en tabla usuarios
			$sql = "UPDATE `usuarios` SET usu_token = '$this->token' WHERE usu_id = '$this->id'";
			$db->query($sql);

			// Realizar commit de todo
			$db->commit();
		}
		catch (PDOException $e)
		{
			$db->rollBack();
        	echo "Error : " . $e->getMessage() . "<br>";
			return false;
		}
	}

  	public function BorraUsuario()
	{
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			// Inicia transacción
			$db->beginTransaction();

			// Borrá lógicamente un usuario en tabla usuarios
			$sql = "UPDATE `usuarios` SET `usu_estado` = '3' WHERE `usu_id` = '$this->id'";
			$db->query($sql);

			// Realizar commit de todo
			$db->commit();

			return true;
		}
		catch (PDOException $e)
		{
        	$db->rollBack();
        	echo "Error : " . $e->getMessage() . "<br>";
			return false;
		}
	 }


	public function ModificaUsuario()
	 {
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			// Inicia transacción
			$db->beginTransaction();

			// Borrá lógicamente un usuario en tabla usuarios
			$sql = "UPDATE `usuarios` SET usu_nombre = '$this->nombre', usu_contrasena = '$this->password', usu_email = '$this->mail', usu_fnacimiento = '$this->fNacimiento', usu_idresidencia = '$this->residencia' WHERE usu_id = '$this->id'";
			$db->query($sql);

			// Realizar commit de todo
			$db->commit();
			return true;
		}
		catch (PDOException $e)
		{
			$db->rollBack();
        	echo "Error : " . $e->getMessage() . "<br>";
			return false;
		}

	 }

	 public function RegistrarUnUsuario()
	 {
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			
			// Inicia transacción
			$db->beginTransaction();
			
			// Inserta usuario en tabla usuarios
			$sql = "INSERT INTO `usuarios` (`usu_nombre`,`usu_email`,`usu_fnacimiento`,`usu_idresidencia`,`usu_contrasena`,`usu_token`) VALUES ('$this->nombre','$this->mail','$this->fNacimiento','$this->residencia','$this->password','$this->token')";

			$db->query($sql);

			// Guarda ID del usuario
			$id = $db->lastInsertId();

			// Registra profesion
			$sql = "INSERT INTO `usuarios_profesiones` (`upro_idusuario`,`upro_idprofesion`) VALUES ('$id','$this->profesion')";
            $db->query($sql);
			
			// Registra modo ingreso
			$sql = "INSERT INTO `usuarios_modoingresos` (`uming_idusuario`,`uming_idmingresos`) VALUES ('$id','$this->modoIngreso')";
            $db->query($sql);

			 // Realizar commit de todo
			$db->commit();
		}
		catch (PDOException $e)
		{
        	$db->rollBack();
        	echo "Error : " . $e->getMessage() . "<br>";
    	}		
	 }

  	public static function TraerTodoLosUsuarios()
	{
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			$sql = "SELECT * FROM usuarios";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$usuarios = $resultado->fetchAll(PDO::FETCH_OBJ);
				echo json_encode($usuarios);
			}else{
				echo json_encode("No existen usuarios en la BBDD");
			}

			$resultado = null; 
        	$db = null;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
    	}
	}

	public static function TraeUnUsuario($token) 
	{
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			$sql = "SELECT * FROM usuarios WHERE usu_token = '$token'";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$usuario = $resultado->fetchAll(PDO::FETCH_OBJ);
				$resultado = null; 
				$db = null;
				return $usuario;			
			}else{
				echo json_encode("No existe este usuario en la BBDD");
			}

		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
    	}


			
	}

	public static function muestraPaises(){
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			$sql = "SELECT * FROM residencias";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$paises = $resultado->fetchAll(PDO::FETCH_ASSOC);
			}else{
				$paises = [];
			}

			return $paises;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
    	} 
	}

	public static function muestraProfesiones(){
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			$sql = "SELECT * FROM profesiones";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$profesiones = $resultado->fetchAll(PDO::FETCH_ASSOC);
			}else{
				$profesiones = [];
			}

			return $profesiones;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
    	} 
	}

	public static function muestraIngresos(){
		try
		{
			$db = new db();
			$db = $db->conectionDB();
			$sql = "SELECT * FROM modos_ingreso";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$modos_ingreso = $resultado->fetchAll(PDO::FETCH_ASSOC);
			}else{
				$modos_ingreso = [];
			}

			return $modos_ingreso;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
    	} 
	}

}