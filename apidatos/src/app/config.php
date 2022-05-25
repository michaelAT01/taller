<?php
$container->set('config_bd', function(){
    return (object)[
        "host" => "localhost",
        "bd" => "taller",
        "usr" => "root", // no se usa root en produccion
        "pass" => "",
        "charset" => "utf8"
    ];
});