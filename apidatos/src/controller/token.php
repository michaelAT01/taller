<?php
namespace App\controller;
use Psr\Container\ContainerInterface;
use Firebase\JWT\JWT;
use PDO;
class Token{
    public function __construct(public ContainerInterface $container){
    }
    public  function generarTokens(string $idUsuario, int $rol)
    {
        //die(getenv('key'));
        $key = getenv('key');
        $payload = [
            "iss" => $_SERVER['SERVER_NAME'],
            "iat" => time(),
            "exp" => time() + (60),
            "sub" => $idUsuario,
            "rol" => $rol
        ];
        $payloadRf = [
            "iss" => $_SERVER['SERVER_NAME'],
            "iat" => time(),
            "rol" => $rol
        ];
        $tkRef= JWT::encode($payloadRf,$key.'HS256');
        //hAY QUE GUARDAR TOKEN de refrescar
        self::modificarToken(idUsuario:$idUsuario,tokenRef:$tkRef);
        return [
            "token" => JWT::encode($payload, $key, 'HS256'),
            "refreshToken"=>$tkRef
        ];
    }
    public  function modificarToken(string $idUsuario, string $tokenRef=""){
        $con = $this->container->get('bd');
        $sql= "select modificarTokenR(.idUsuario,:tk);";
        $query=$con-> prepaare($sql);
        $query->execute(["idUsuario"=>$idUsuario,"tk"=>$tokenRef]);
        $datos=$query->fetch(PDO::FETCH_NUM);
        $query=null;
        $con= null;
        return $datos;
    }
}