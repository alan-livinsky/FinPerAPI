<?php

require_once('../../config/AccesoDatos.php');
require_once('../../cors.php');
require_once('../../classes/Usuario.php');

$methodHTTP = $_SERVER['REQUEST_METHOD'];
// if(isset($_REQUEST['usuario']) && isset($_REQUEST['contrasena'])){
//     $accion = 'Login';
// }
// else
// {
//     $accion = 'sadf';
// }

switch($methodHTTP){
    case 'GET':
        switch($accion){
            case 'Login':
                $ctl = new Usuario();
                $data = $ctl->validaLogin();
                echo json_encode(["data" => $data]);
                break;
            default:
                echo 'Nada';
                break;
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $ctrl = new Usuario();
        $ctrl->registraUsuario($data);
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        $ctrl = new Movimiento();
        $ctrl->registraUsuario($data-> ,$data->tipo);
        break;
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        $ctrl = new Movimiento();
        $ctrl->registraUsuario($data-> ,$data->tipo);
        break;
}