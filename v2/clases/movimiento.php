<?php

class movimiento
{
	public $id;
	public $monto;
	public $tipo;
	public $userId;

  	public static function TraeMovimientos($id)
	 {
		try
		{
			$db = new db();
			$db = $db->conectionDB();

			// Trae todos los movimientos del usuario
			$sql = "SELECT TIP.tmov_descripcion, CAT.cmov_descripcion, MON.mon_descripcion, MOV.mov_monto, 			MOV.mov_fcreacion
					FROM categorias_movimientos CAT, tipos_movimientos TIP, movimientos MOV, monedas MON
					WHERE CAT.cmov_id = MOV.mov_idcategoria
					AND TIP.tmov_id = MOV.mov_idtipo
					AND MON.mon_id = MOV.mov_idmoneda
					AND MOV.mov_idusuario = '$id'
					ORDER BY MOV.mov_fcreacion";
			$resultado = $db->query($sql);
			$movimientos = array();
			if ($resultado->rowCount() > 0){
				$movimientos = $resultado->fetchAll(PDO::FETCH_OBJ);
			}else{
				echo json_encode("No existen movimientos en la BBDD");
			}
			return $movimientos;
		}
		catch (PDOException $e)
		{
        	echo "Error : " . $e->getMessage() . "<br>";
			return false;
		}
	 }

	 public static function cargaMovimiento($idUsuario, $idMoneda, $idCategoria, $idTipo, $monto){
		try 
		{
			$db = new db();
			$db = $db->conectionDB();

			$sql = "INSERT INTO `movimientos` (`mov_idusuario`,`mov_idmoneda`,`mov_idcategoria`,`mov_idtipo`,`mov_monto`) VALUES ($idUsuario, $idMoneda, $idCategoria, $idTipo, $monto)";
			$resultado = $db->query($sql);
		} 
		catch (Exception $err) {
			throw $err;
		}
	 }
}