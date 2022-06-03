<?php

require_once('../../config/AccesoDatos.php');
require_once('../../cors.php');
require_once('../../classes/Movimiento.php');

$methodHTTP = $_SERVER['REQUEST_METHOD'];
if(isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];
}

switch($methodHTTP){
    case 'GET':
        $ctl = new Movimiento();
        $data = $ctl->traeMovimientos();
        echo json_encode(["data" => $data]);
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        $ctrl = new Movimiento();
        $ctrl->insertaMovimiento($data->monto,$data->tipo);
        
        break;
}