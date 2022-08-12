<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-API-KEY, Origin, Authorization, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Request-Method: GET, POST, OPTIONS, PUT, DELETE');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


require_once 'vendor/autoload.php';
require_once 'config/db.php';
require_once 'api/usuarioApi.php';
// require_once 'api/movimientoApi.php';
require_once 'config/AuthJWT.php';
// require_once 'config/MWCors.php';
// require_once 'config/MWAuth.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*

¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);



/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/
// $app->group('/usuarios', function () {
 
//   $this->get('/', \usuarioApi::class . ':traeTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');
 
//   $this->get('/{id}', \cdApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');

//   $this->post('/', \cdApi::class . ':CargarUno');

//   $this->delete('/', \cdApi::class . ':BorrarUno');

//   $this->put('/', \cdApi::class . ':ModificarUno');

// })->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/usuarios', function () {
  
  $this->get('/', \usuarioApi::class . ':TraeTodos');

  $this->get('/paises', \usuarioApi::class . ':TraePaises');

  $this->get('/profesiones', \usuarioApi::class . ':TraeProfesiones');

  $this->get('/modosingresos', \usuarioApi::class . ':TraeIngresos');
  
  $this->post('/id/token', \usuarioApi::class . ':DatosUsuario');
  
  $this->post('/login', \usuarioApi::class . ':Login');

  $this->post('/', \usuarioApi::class . ':RegistraUsuario');

  $this->post('/{id}', \usuarioApi::class . ':ValidaToken');
  
  $this->delete('/{id}', \usuarioApi::class . ':BorraUno');
  
  $this->put('/', \usuarioApi::class . ':ModificarUsuario');

});

// $app->group('/movimientos', function () {
  
  // $this->get('/', \usuarioApi::class . ':TraeTodos');
  
  // $this->post('/{id}', \movimientoApi::class . ':TraeMovimientosDeUsuario');
  
  // $this->post('/', \usuarioApi::class . ':RegistraUsuario');
  
  // $this->delete('/{id}', \usuarioApi::class . ':BorraUno');
  
  // $this->put('/', \usuarioApi::class . ':ModificarUsuario');

// });



$app->run();