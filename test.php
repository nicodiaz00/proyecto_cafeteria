<?php

require_once ("Producto.php");


/*
function cargaProductoJson(){
    $arreglo=[];
    $jsonGet=file_get_contents("Json/Productos.json");
    $jsonInfo=json_decode($jsonGet,true);
    $arreglo[]=$jsonInfo;
    return $arreglo;

}

$muestra= cargaProductoJson();

print_r($muestra);
*/
//$jsonGet=file_get_contents("Json/Productos.json");

//$productos = json_decode($jsonGet, true);  // true para obtener un array asociativo

//$arregloProductos=[];


// Imprimir para verificar el contenido
//print_r($productos);
/*
foreach ($productos as $producto) {
    global $arregloProductos;
    $p1 = new Producto($producto["Nombre"], $producto["Precio"],$producto["Descripcion"],$producto["Tipo"]);
    $arregloProductos[] = $p1;
}
*/

function lecturaJson($infoJson)
{
    $jsonArchivo = file_get_contents($infoJson);
    $arregloJson = json_decode($jsonArchivo, true);
    return $arregloJson;
}

$variable= lecturaJson("Json/Productos.json");

//print_r($variable);

function creaProductoYCarga($arreglo)
{
    $arregloDeProductos=[];
    foreach ($arreglo as $pr) {
        $productoAux = new Producto($pr['Nombre'],$pr['Precio'], $pr['Descripcion'], $pr['Tipo']);
        $arregloDeProductos[] = $productoAux;
    }
    return $arregloDeProductos;
}
$arrayOfProducts = creaProductoYCarga($variable);

var_dump($arrayOfProducts[1]);