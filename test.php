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
/*
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

function convertirArregloToArregloAsociativo($arreglo){
    $arregloAsociativo =[];
    foreach ($arreglo as $producto) {
        $arregloAsociativo[] = $producto->serialize();
    }
    return $arregloAsociativo;
}

$unavariable= convertirArregloToArregloAsociativo($arrayOfProducts);

Echo "Muestro el arreglo de productos leido desde un json \n";
var_dump($arrayOfProducts);
echo "Muestro un elemento desde un arreglo de productos pasado a un array asociativo: \n";
var_dump($unavariable[0]);

$p1= file_get_contents("Json/Productos.json");

$p2= json_decode($p1, true);

echo "mostrando lo que tiene el json \n";
var_dump($p2);

function guardarInformacion($archivoJson,$arreglo){
    $leerArreglo = json_encode($arreglo,true);
    file_put_contents($archivoJson,$leerArreglo);
}
*/
$arregloDeObjetos =[];

$producto1 =new Producto("agua",100,"Agua mineral","Bebida");
$producto2= new Producto("Gaseosa",200,"Coca cola","Bebida");
$producto3=new Producto("Pizza",300,"Pizza individual","Sandwich");

$arregloDeObjetos[] = $producto1;
$arregloDeObjetos[] = $producto2;
$arregloDeObjetos[] = $producto3;

var_dump($arregloDeObjetos);

function objToarray($arrayObj){
    $arrayAsociativo=[];
    foreach ($arrayObj as $producto) {

        echo $producto->serialize();
        $arrayAsociativo[] = $producto->serialize();
    }
    return $arrayAsociativo;
}
$variabledeproductos = objToarray($arregloDeObjetos);

//array to json

$toJson = json_encode($variabledeproductos,JSON_PRETTY_PRINT);


file_put_contents("Json/practicaJson.json", $toJson);

$jsonContenido = file_get_contents('Json/practicaJson.json');

// Mostrar el contenido directamente
echo $jsonContenido;

//leo el json:

$x = file_get_contents("Json/practicaJson.json");

//el json que esta en una variable lo transformo en un arreglo asociativo:
$z = json_decode($x,true);


//a ese arreglo lo paso a objetos:


function creoProducto($arreglo)
{
    $arregloObjeto =[];
    foreach ($arreglo as $pr) {
        $p = new Producto($pr['Nombre'], $pr['Precio'], $pr['Descripcion'], $pr['Tipo']);
        $arregloObjeto[] = $p;
    }
    return $arregloObjeto;
}

echo "mostrando algo \n";
var_dump($z);

//llamo a la funcion:

$otravariable = creoProducto($z);

var_dump($otravariable);

var_dump($arregloDeObjetos);