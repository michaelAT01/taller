<?php 
namespace App\controller;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use PDO;
use PDOException;

class Tecnico extends Usuario{
    public function __construct(public ContainerInterface $container){  }
    public function crearTecnico(Request $request, Response $response, $args)
{
    $body = json_decode($request->getBody());
    $body->idTecnico = "T" . $body->idTecnico;
    $sql = "select nuevoTecnico(";
    $d = [];
    foreach ($body as $campo => $valor) {
        $sql .= ":$campo,";
        $d[$campo] = filter_var($valor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    $sql = rtrim($sql, ',') . ");";
    $d['idUsuario'] = $d['idTecnico'];
    //Esta linea puede ser del cliente o generado automaticamente
    $d['passw'] = Hash::hash($d['idTecnico']);
    $res = $this->guardarUsuario($sql, $d, 3);
    $status = $res == 0 ? 201 : 409;
    return $response
        ->withStatus($status);
}
public function modificar(Request $request, Response $response, $args)
{
    //$id = $args['id'];
    $body = json_decode($request->getBody());

    $sql = "select editarTecnico(:id,";
    $d['id'] = $args['id'];
    foreach ($body as $campo => $valor) {
        $sql .= ":$campo,";
        $d[$campo] = filter_var($valor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }
    $sql = rtrim($sql, ',') . ");";

    $con = $this->container->get('bd');
    $query  = $con->prepare($sql);
    $query->execute($d);
    $res = $query->fetch(PDO::FETCH_NUM);

    $query = null;
    $con = null;

    $status = $res[0] > 0 ? 200 : 404;
    return $response
        ->withHeader('Content-Type', 'Application/json')
        ->withStatus($status);
}
public function eliminar(Request $request, Response $response, $args)
{
    $sql = "select eliminarTecnico(:id);"; //LLamada de procedimiento en sql
    $con = $this->container->get('bd');
    $query = $con->prepare($sql);
    $query->bindParam('id', $args['id'], PDO::PARAM_INT);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_NUM);
    $status = $res > 0 ? 200 : 404;
    $query = null;
    $con = null;
    return $response
        ->withStatus($status);
}
public function filtrar(Request $request, Response $response, $args)
    {
        //Retornar todos los registros con limit
        $limite = $args['limite'];
        $indice = ($args['indice'] - 1) * $limite;
        $datos = $request->getQueryParams();
        $cadena = "";
        foreach ($datos as $valor) {
            $cadena .= "%$valor%&";
        }
        $sql = "call filtrarTecnico('$cadena', '$indice', '$limite');";
        $con = $this->container->get('bd');
        $query = $con->prepare($sql);
        $query->execute();
        $status = $query->rowCount() > 0 ? 200 : 204;
        $res = $query->fetchAll();

        $query = null;
        $con = null;

        $response->getBody()->write(json_encode($res));
        return $response
            ->withHeader('Content-Type', 'Application/json')
            ->withStatus($status);
    }

}