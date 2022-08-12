<?php 

interface MovimientoI{ 
	
	public function TraeMovimientosDeUsuario($request, $response, $args);
	public function CargaUnMovimiento($request, $response, $args);
	// public function TraeTodosConFiltro($request, $response, $args);
   	// public function TraerUno($request, $response, $args);
   	
   	// public function BorraUno($request, $response, $args);
   	// public function ModificaMovimiento($request, $response, $args);

}