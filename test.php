<?php

require_once ("Producto.php");

require_once ("Json/Productos.json");

function cargaProductoJson(){
    $arreglo=[];
    $jsonGet=file_get_contents("Json/Productos.json");
    $jsonInfo=json_decode($jsonGet,true);
    $arreglo[]=$jsonInfo;
    return $arreglo;

}

$muestra= cargaProductoJson();

print_r($muestra[1]["Nombre"]);



