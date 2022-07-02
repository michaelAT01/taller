<?php

namespace App\Controller;

use App\controller\Oficinista;
use App\controller\Tecnico;
use Slim\Routing\RouteCollectorProxy;

//require __DIR__ . '/../controller/Artefacto.php';
//use App\controller\Artefacto;
$app->group('/articulo', function (RouteCollectorProxy $articulo) {

    //Retornar todos los registros con limit
    $articulo->get('/{indice}/{limite}', Artefacto::class . ':mostrarTodos');

    //Retornar un registro por código  
    $articulo->get('/{id}', Artefacto::class . ':buscar');

    //Retorna registros filtrados con limit
    $articulo->get('/filtro/{indice}/{limite}', Artefacto::class . ':filtrar');

    //Crear nuevo  
    $articulo->post('/', Artefacto::class . ':crear');

    //modificar 
    $articulo->put('/{id}', Artefacto::class . ':modificar');

    //eliminar
    $articulo->delete('/{id}', Artefacto::class . ':eliminar');
});

$app->group('/Cliente', function (RouteCollectorProxy $cliente) {

    //Retornar todos los registros con limit
    $cliente->get('/{indice}/{limite}', Cliente::class . ':mostrarTodos');
    //Retornar un registro por código  
    $cliente->get('/{id}', Cliente::class . ':buscar');
    //Crear nuevo  
    $cliente->post('/', Cliente::class . ':crear');
    //modificar 
    $cliente->put('/{id}', Cliente::class . ':modificar');
    //eliminar
    $cliente->delete('/{id}', Cliente::class . ':eliminar');
});

$app->group('/filtro', function (RouteCollectorProxy $filtro) {
    $filtro->group('/Cliente', function (RouteCollectorProxy $cliente) {
        //Retorna registros filtrados con limit
        $cliente->get('/{indice}/{limite}', Cliente::class . ':filtrar');

        $cliente->get('/numregs', Cliente::class . ':numRegs');
    });
    $filtro->group('/admin', function (RouteCollectorProxy $admin) {
        //Retorna registros filtrados con limit
        $admin->get('/{indice}/{limite}', Administrador::class . ':filtrar');

        $admin->get('/numregs', Administrador::class . ':numRegs');
    });
});

$app->group('/auth', function (RouteCollectorProxy $auth) {
    $auth->post('/iniciar', Auth::class . ':iniciarSesion');
    $auth->patch('/cerrar', Auth::class . ':cerrarSesion');
    $auth->patch('/refrescar', Auth::class . ':refrescarSesion');
});

$app->group('/admin', function (RouteCollectorProxy $admin) {

    //Retornar un registro por código  
    $admin->get('/{id}', Administrador::class . ':buscarAdmin');

    //Crear nuevo  
    $admin->post('', Administrador::class . ':crear');

    //modificar 
    $admin->put('/{id}', Administrador::class . ':modificar');

    //eliminar
    $admin->delete('/{id}', Administrador::class . ':eliminar');
});
$app->group('/usuario', function (RouteCollectorProxy $usuario) {
    $usuario->patch('/rol', Auth::class . ':cambiarRol');
    $usuario->group('/passw',function (RouteCollectorProxy $passw){
        $passw->patch('/cambio', Auth::class . ':cambiarPassw'); 
        $passw->patch('/reset', Auth::class . ':resetPassw');
    });
    
});
$app->group('/tecnico', function (RouteCollectorProxy $tecnico) {

    //Retornar todos los registros con limit
    $tecnico->get('/{indice}/{limite}', Tecnico::class . ':filtrar');
    //Retornar un registro por código  
    $tecnico->get('/{id}', Tecnico::class . ':buscar');
    //Crear nuevo  
    $tecnico->post('/', Tecnico::class . ':crearTecnico');
    //modificar 
    $tecnico->put('/{id}', Tecnico::class  . ':modificar');
    //eliminar
    $tecnico->delete('/{id}', Tecnico::class . ':eliminar');
});
$app->group('/oficinista', function (RouteCollectorProxy $oficinista) {

    //Retornar todos los registros con limit
    $oficinista->get('/{indice}/{limite}', Oficinista::class . ':filtrar');
    //Retornar un registro por código  
    //$oficinista->get('/{id}', Oficinista::class . ':buscar');
    //Crear nuevo  
    $oficinista->post('/', Oficinista::class . ':crearOficinista');
    //modificar 
    $oficinista->put('/{id}', Oficinista::class . ':modificar');
    //eliminar
    $oficinista->delete('/{id}', Oficinista::class . ':eliminar');
});

