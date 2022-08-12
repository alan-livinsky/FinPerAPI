<?php
require_once 'clases/usuario.php';
require_once 'interfaces/usuarioI.php';

class usuarioApi extends usuario implements UsuarioI
{

    /*============================================
    Login Usuario
    ============================================*/

 	public function Login($request, $response, $args) {
        // Toma datos
        $ArrayDeParametros = $request->getParsedBody();
        // Instacia Usuario y da valor a atributos mail y password
        $usuario = new usuario();
        $usuario->mail=$ArrayDeParametros['mail'];
        $usuario->password=sha1($ArrayDeParametros['contrasena']);
        // Valida login
        

        $validado = $usuario->ValidaUsuario();
        $objDelaRespuesta= new stdclass();

        if(!$validado){
            $objDelaRespuesta->error="Algo salio mal";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
            // usuario::
        }else{
            $data = array(
                'nombre'=> $usuario->nombre,
                'mail' => $usuario->mail
            );

            // Genera y guarda token en bd
            $usuario->token=AuthJWT::CrearToken($data);
            $usuario->UpdateToken();

            // Respuesta en JSON
            $objDelaRespuesta->respuesta = "Autorizado.";   
            $objDelaRespuesta->token = $usuario->token;   
            $objDelaRespuesta->id = $usuario->id;   
            $objDelaRespuesta->name = $usuario->nombre;   
            $objDelaRespuesta->mail = $usuario->mail;   
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 200); 
        }

        return $NuevaRespuesta;
    }

    /*============================================
    Muestra un usuario
    ============================================*/

 	public function ValidaToken($request, $response, $args) {
        $id=$args['id'];
        $usuario=usuario::TraeUnUsuario($id);
        if(!$usuario)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No existe el usuario";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {
            $NuevaRespuesta = $response->withJson($usuario, 200); 
        }     
        return $NuevaRespuesta;
    }

    /*============================================
    Muestra un usuario
    ============================================*/

 	public function TraerUno($request, $response, $args) {
        $id=$args['id'];
        $usuario=usuario::TraeUnUsuario($id);
        if(!$usuario)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No existe el usuario";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {
            $NuevaRespuesta = $response->withJson($usuario, 200); 
        }     
        return $NuevaRespuesta;
    }

    /*============================================
    Muestra un usuario
    ============================================*/

 	public function DatosUsuario($request, $response, $args) {
        $ArrayDeParametros = $request->getParsedBody();
        $usuario=usuario::TraeUnUsuario($ArrayDeParametros['token']);
        if(!$usuario)
        {
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->error="No existe el usuario";
            $NuevaRespuesta = $response->withJson($objDelaRespuesta, 500); 
        }else
        {
            $NuevaRespuesta = $response->withJson($usuario, 200); 
        }     
        return $NuevaRespuesta;
    }

    /*============================================
    Muestra Todos Los Usuarios
    ============================================*/

     public function TraeTodos($request, $response, $args) {
      	$todosLosUsuarios=usuario::TraerTodoLosUsuarios();
     	$newresponse = $response->withJson($todosLosUsuarios, 200);  
    	return $newresponse;
    }

    /*============================================
    Registra Usuario
    ============================================*/

    public function RegistraUsuario($request, $response, $args) {
    
        $objDelaRespuesta= new stdclass();
        
        $ArrayDeParametros = $request->getParsedBody();
        $password= sha1($ArrayDeParametros['contrasena']);
        $fNacimiento= $ArrayDeParametros['fnacimiento'];
        $mail= $ArrayDeParametros['mail'];
        $modoIngreso= $ArrayDeParametros['modoIngreso'];
        $nombre= $ArrayDeParametros['nombre'];
        $profesion= $ArrayDeParametros['profesion'];
        $residencia= $ArrayDeParametros['residencia'];

        $data = array(
            'nombre'=> $nombre,
            'mail' => $mail,
            'fNacimiento' => $fNacimiento,
            'residencia'=> $residencia
        );
        
        $usuario = new usuario();
        $usuario->nombre=$nombre;
        $usuario->fNacimiento=$fNacimiento;
        $usuario->password=$password;
        $usuario->mail=$mail;
        $usuario->modoIngreso=$modoIngreso;
        $usuario->profesion=$profesion;
        $usuario->residencia=$residencia;
        $usuario->token=AuthJWT::CrearToken($data);
        // $usuario->tokenExp;
        $usuario->RegistrarUnUsuario();
        $objDelaRespuesta->respuesta = "Usuario Registrado.";   
        $objDelaRespuesta->token = $usuario->token;   
        return $response->withJson($objDelaRespuesta, 200);
    }

    /*============================================
    Borra un usuario
    ============================================*/

    public function BorraUno($request, $response, $args) {
        // $ArrayDeParametros = $request->getParsedBody();
        $id=$args['id'];
        $usuario= new usuario();
        $usuario->id=$id;
        $borrado=$usuario->BorraUsuario();

        $objDelaRespuesta= new stdclass();
        $objDelaRespuesta->borrado=$borrado;
        if($borrado)
        {
                $objDelaRespuesta->resultado="Usuario borrado";
        }
        else
        {
            $objDelaRespuesta->resultado="No existe el usuario";
        }

        return $response->withJson($objDelaRespuesta, 200);
    }

    /*============================================
    Modifica un usuario
    ============================================*/
     
    public function ModificarUsuario($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
	    $usuario = new usuario();
	    $usuario->id=$ArrayDeParametros['id'];
	    $usuario->password=sha1($ArrayDeParametros['contrasena']);
	    $usuario->nombre=$ArrayDeParametros['nombre'];
	    $usuario->mail=$ArrayDeParametros['mail'];
	    $usuario->fNacimiento=$ArrayDeParametros['fnacimiento'];
	    $usuario->residencia=$ArrayDeParametros['residencia'];

	   	$modificado =$usuario->ModificaUsuario();

	   	$objDelaRespuesta= new stdclass();
        $objDelaRespuesta->modificado=$modificado;

        if($modificado)
        {
            $objDelaRespuesta->resultado="Usuario modificado";
        }
        else
        {
            $objDelaRespuesta->resultado="No existe el usuario";
        }

		return $response->withJson($objDelaRespuesta, 200);		
    }

    /*============================================
    Trae paises
    ============================================*/

    public function TraePaises($request, $response, $args) {
        $paises=usuario::muestraPaises();
        $newresponse = $response->withJson($paises, 200);  
       return $newresponse;
    }

    /*============================================
    Trae paises
    ============================================*/

    public function TraeProfesiones($request, $response, $args) {
        $paises=usuario::muestraProfesiones();
        $newresponse = $response->withJson($paises, 200);  
       return $newresponse;
    }

    /*============================================
    Trae paises
    ============================================*/

    public function TraeIngresos($request, $response, $args) {
        $paises=usuario::muestraIngresos();
        $newresponse = $response->withJson($paises, 200);  
       return $newresponse;
    }
}