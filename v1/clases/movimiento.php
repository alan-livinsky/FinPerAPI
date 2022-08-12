<?php
class movimiento
{
	public $id;
	public $monto;
	public $tipo;
	public $userId;

  	public static function TraeMovimientosDeUsuario($id)
	 {
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			// Borrá lógicamente un usuario en tabla usuarios
			$sql = "SELECT * from movimientos WHERE mov_idusuario";
			$resultado = $db->query($sql);

			if ($resultado->rowCount() > 0){
				$movimientos = $resultado->fetchAll(PDO::FETCH_OBJ);
				echo json_encode($movimientos);
			}else{
				echo json_encode("No existen movimientos en la BBDD");
			}

			return true;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
			return false;
		}
	 }
}