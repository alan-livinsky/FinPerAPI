<?php
require_once 'clases/movimiento.php';
require_once 'interfaces/movimientoI.php';

class movimientoApi extends movimiento implements MovimientoI
{

    /*============================================
            Trae movimientos de un usuario
    ============================================*/

 	public function TraeMovimientosDeUsuario($request, $response, $args) {
        $idUsuario=$args['id'];
        $movimientos=movimiento::TraeMovimientos($idUsuario);
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

     /*============================================
            Muestra un usuario
    ============================================*/

    public function CargaUnMovimiento($request, $response, $args){
        $monto = $args[''];
        $idUsuario = $args[''];
        $idCategoria = $args[''];
        $idMoneda = 1;
        $idTipo = $args[''];
        $movimientos=movimiento::CargaMovimiento($idUsuario);
    }

}