<?php
require_once 'clases/movimiento.php';
require_once 'interfaces/movimientoI.php';

class movimientosApi extends movimiento implements MovimientoI
{

    /*============================================
    Muestra un usuario
    ============================================*/

 	public function TraeMovimientosDeUsuario($request, $response, $args) {
        $idUsuario=$args['id'];
        $movimientos=movimiento::TraeMovimientosDeUsuario($idUsuario);
        if(!$movimientos)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No existen movimientos";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {

            $NuevaRespuesta = $response->withJson($movimientos, 200); 
        }     
        return $NuevaRespuesta;
    }
}