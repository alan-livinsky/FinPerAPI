<?php 

interface UsuarioI{ 
	
	public function TraeTodos($request, $response, $args); 
   	public function TraerUno($request, $response, $args); 
   	public function DatosUsuario($request, $response, $args); 
   	public function RegistraUsuario($request, $response, $args);
   	public function BorraUno($request, $response, $args);
   	public function ValidaToken($request, $response, $args);
   	public function Login($request, $response, $args);
   	public function ModificarUsuario($request, $response, $args);
   	public function TraePaises($request, $response, $args);
   	public function TraeProfesiones($request, $response, $args);
   	public function TraeIngresos($request, $response, $args);

}