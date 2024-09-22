<?php
require_once ('Pedido.php');
require_once ('Cliente.php');
require_once ('Producto.php');


//arreglos que contendran clientes, productos y pedidos al ejecutar el sistema.
$clientes =[];
$productos =[];
$pedidos =[];
$productosJson =[];

//lectura y creacion de Json

function lecturaJson($infoJson)
{
    $jsonArchivo = file_get_contents($infoJson);
    $arregloJson = json_decode($jsonArchivo, true);
    return $arregloJson;
}

function guardarInformacion($archivoJson,$arreglo){
    $info =json_encode($arreglo);
    file_put_contents($archivoJson,$info);
}
function creaProductoYCarga($arreglo)
{
    global $productosJson;
    foreach ($arreglo as $pr) {
        $productoAux = new Producto($pr['Nombre'],$pr['Precio'], $pr['Descripcion'], $pr['Tipo']);
        $productosJson[] = $productoAux;
    }
    return $productosJson;
}
//carga del sistema


function cargarSistema($parametro1){
    $variable1 = lecturaJson($parametro1);
    creaProductoYCarga($variable1);
}




//-------------------seccion producto--------------------

//menu producto
function gestionProducto()
{
    echo "Seleccione opcion deseada: \n";
    echo "0- Volve atras \n";
    echo "1- Crear y cargar producto a stock\n";
    echo "2- Listar los productos \n";
    echo "3- Eliminar producto del stock \n";
    echo "4- listar desde arreglo json \n";
    $opcion=trim(fgets(STDIN));

    switch ($opcion){
        case 0:
            return;
        case 1:
            crearProducto();
            break;
        case 2:
            mostrarProducto();
            break;
        case 3:
            eliminarProducto();
            break;
        case 4:
            listarProducto();
            break;
    }
}
//funcion crea 3 productos para tener un stock generico.
function cargarStock(){
    global $productos;
    $producto1 = new Producto("Cafe",3,"Cafe Mediano","Bebida");
    $producto2 = new Producto("Te",1,"Te en hebras","Bebida");
    $producto3 = new Producto("Tostado",5,"Sandwich jamon y queso","Sandwich");

    $productos[]=$producto1;
    $productos[]=$producto2;
    $productos[]=$producto3;
}
function listarProducto(){
    global $productosJson;
    foreach ($productosJson as $producto){
        echo "Nombre: " .$producto->getNombre() .", Precio: " .$producto->getPrecio().", Descripcion: ".$producto->getDescripcion().", Tipo: ".$producto->getTipo()."\n";
        echo "--------------------------------- \n";
    }
    echo "Presione ENTER para continuar...\n";
    trim(fgets(STDIN));
}
function mostrarProducto()
{
    global $productos;
    foreach ( $productos as $producto) {
        echo "Nombre: " .$producto->getNombre() .", Precio: " .$producto->getPrecio().", Descripcion: ".$producto->getDescripcion().", Tipo: ".$producto->getTipo()."\n";
        echo "--------------------------------- \n";
        //echo "Precio: " .$producto->getPrecio() ."\n";
        //echo "Descripcion: " .$producto->getDescripcion() ."\n";
        //echo "Tipo: " .$producto->getTipo() ."\n";
    }
    echo "Presione ENTER para continuar...\n";
    trim(fgets(STDIN));
}
//funcion para ingresar productos al stock de la cafeteria
function cargarProducto($producto){
    global $productosJson;
    $productosJson[]=$producto;
}
//funcion para crear un nuevo producto y llamo a "cargarProducto()"
function crearProducto(){
    echo"---------\n";
    echo "Ingrese nombre producto: \n";
    $nombre =trim(fgets(STDIN));
    echo "Ingrese precio: \n";
    $precio = trim(fgets(STDIN));
    echo "Ingrese descripcion: \n";
    $descripcion = trim(fgets(STDIN));
    echo "Ingrese tipo: 'bebida' o 'sandwich' \n";
    $tipo=trim(fgets(STDIN));

    $producto = new Producto($nombre,$precio,$descripcion,$tipo);
    cargarProducto($producto);
    echo "Producto agregado al stock \n";


}
function eliminarProducto()
{
    global $productos;
    $cantidad=recorrerArreglo($productos);
    $posicion=-1;
    $stockProductos=[];
    echo "Ingrese el nombre del producto a eliminar: \n";
    $nombre =trim(fgets(STDIN));
    for($i=0;$i<$cantidad;$i++){
        if($productos[$i]->getNombre() == $nombre){
            $posicion = $i;
            break;
        }
    }
    if($posicion == -1){
        echo "Producto no encontrado \n";


    }
    for($i=0;$i<$cantidad;$i++){
        if($i != $posicion){
            $stockProductos[]=$productos[$i];
        }
    }
    $productos=$stockProductos;
    echo "Producto eliminado \n";
    return $productos;



}
function recorrerArreglo($arreglo){
    $contador=0;
    foreach ($arreglo as $elemento) {
        $contador++;
    }
    return $contador;
}

//--------------------Seccion cliente--------------------
function gestionCliente()
{
    echo "--------- \n";
    echo "Seleccione una opcion deseada: \n";
    echo "0-Volver atras \n";
    echo "1-Crear Cliente\n";
    echo "2-Listar Clientes \n";
    echo "3-Eliminar Cliente \n";
    $opcion=trim(fgets(STDIN));

    switch ($opcion){
        case 0:

            return;
        case 1:
            crearCliente();
            break;
        case 2:
            listarClientes();
            break;
        case 3:
            echo "aca eliminamos clientes";
            break;
    }
}
function listarClientes(){
    global $clientes;
    if(recorrerArreglo($clientes)==0){
        echo "No hay clientes registrados.. \n";
    }else{
        foreach ($clientes as $cliente){
            echo "NOMBRE: " .$cliente->getNombre() ." , DNI: ".$cliente->getDni() ."\n";
            echo "---------- \n";
        }
    }

    echo "Presione ENTER para continuar...\n";
    trim(fgets(STDIN));
}

function comprobarCliente($dni){
    global $clientes;
    foreach ($clientes as $cliente) {
        if($cliente->getDni() != $dni){
            crearCliente($dni);
        }else{
            echo "cliente registrado";
        }
    }
}
function crearCliente(){
    global $clientes;
    $nuevoCliente=Cliente::crearCliente();
    echo "Ingrese nombre: \n";
    $nombre =trim(fgets(STDIN));
    echo "Ingrese apellido: \n";
    $apellido = trim(fgets(STDIN));
    echo "Ingrese DNI: \n";
    $dniCliente = trim(fgets(STDIN));


    $nuevoCliente->setNombre($nombre);
    $nuevoCliente->setApellido($apellido);
    $nuevoCliente->setDni($dniCliente);

    $clientes[]=$nuevoCliente;
    echo "Cliente creado con exito, presione ENTER para continuar \n";
    trim(fgets(STDIN));
}

//--------------------SECCION DE PEDIDOS-------------------
function crearPedidoCargarProducto(){
    $unPedido=crearPedido();
    $pedidoAux=agregarProductosAlpedido($unPedido);
    cargarPedido($pedidoAux);

}
function crearPedido()
{
    echo "Ingrese su DNI: ";
    $dni = trim(fgets(STDIN));
    $pedido1=Pedido::crear();
    $pedido1->setCodigoCliente($dni);
    return $pedido1;
}
//cargar pedido a lista de pedidos:

function cargarPedido($pedido){
    global $pedidos;
     $pedidos[]=$pedido;
}
function carta(){
    global $productos;
    for ($i=0;$i<count($productos);$i++){

        echo $i+1 ."-Nombre:" .$productos[$i]->getNombre() .",Descripcion: ".$productos[$i]->getDescripcion().", Precio: ".$productos[$i]->getPrecio()."\n";
        echo "----- \n";
    }
}

function agregarProductosAlpedido(Pedido $pedido)
{
    global $productos;
    carta();
    echo "Seleccione la opcion 1, 2, o 3 para cargar un producto a su pedido: \n";
    $opcion=trim(fgets(STDIN));
    while($opcion!=0){
        for($i=0;$i<count($productos);$i++){
            if($i== $opcion-1){
                $pedido->setListaProducto($productos[$i]);

            }
        }
        carta();
        echo "Ingrese 1,2,3 para seguir agregando productos a su pedido o CERO para finalizar: ";
        $opcion=trim(fgets(STDIN));

    }
    echo "productos agregados adios";
    return $pedido;
}
function gestionPedido(){
    echo "--------- \n";
    echo "Seleccione una opcion deseada: \n";
    echo "0-Volver atras \n";
    echo "1-Crear Pedido\n";
    echo "2-Listar Pedidos \n";
    echo "3-Cancelar Pedido \n";
    $opcion=trim(fgets(STDIN));

    switch ($opcion){
        case 0:
            return;
        case 1:
            crearPedidoCargarProducto();
            break;
        case 2:
            listarPedidos();
            break;
        case 3:
            crearPedido();
            break;


    }

}
function listarPedidos()
{
    global $pedidos;
    if(count($pedidos)==0){
        echo "No hay pedidos creados \n";
        echo "Presione ENTER para continuar...\n";
        trim(fgets(STDIN));
    }else{
        foreach ($pedidos as $pedido){
            echo "CodigoPedido: " .$pedido->getCodigo() ."\n";
            echo "Monto total: " .$pedido->calcularTotal() ."\n";

        }

    }

}