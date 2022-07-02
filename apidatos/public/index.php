<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-API-KEY,Origin, X-Request-Width,Content-Type,Accept-Control-Request-Method,Authorization');
header('Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE, PATCH');
header('Allow:GET,POST,OPTIONS,PUT,DELETE, PATCH');
if ($_SERVER['REQUEST_METHOD']=='OPTIONS'){
die('Metodo no permitido');
}
require_once  "../src/app/app.php";




