<?php
require_once ('Pedido.php');
require_once ('Cliente.php');
require_once ('Producto.php');

//arreglos que contendran clientes, productos y pedidos al ejecutar el sistema.
$clientes =[];
$productos =[];
$pedidos =[];

//funciones para la gestion de producto

function gestionProducto()
{
    echo "Seleccione opcion deseada: \n";
    echo "0- Volve atras \n";
    echo "1- Crear y cargar producto a stock\n";
    echo "2- Listar los productos \n";
    echo "3- Eliminar producto del stock \n";
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
    }
}
function cargarStock(){
    global $productos;
    $producto1 = new Producto("Cafe",3,"Cafe Mediano","Bebida");
    $producto2 = new Producto("Te",1,"Te en hebras","Bebida");
    $producto3 = new Producto("Tostado",5,"Sandwich jamon y queso","Sandwich");

    $productos[]=$producto1;
    $productos[]=$producto2;
    $productos[]=$producto3;
}
function mostrarProducto()
{
    global $productos;
    foreach ( $productos as $producto) {
        echo "--------------------------------- \n";
        echo "Nombre: " .$producto->getNombre()."\n";
        echo "Precio: " .$producto->getPrecio() ."\n";
        echo "Descripcion: " .$producto->getDescripcion() ."\n";
        echo "Tipo: " .$producto->getTipo() ."\n";
    }
    echo "Presione Enter para volver al menú de gestión de productos...";
    fgets(STDIN);
}

function cargarProducto($producto){ //funcion para ingresar productos al stock de la cafeteria
    global $productos;
    $productos[]=$producto;

}
function crearProducto(){ //funcion para crear un nuevo producto y cargarlo al stock.
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
        return $productos;
    }
    for($i=0;$i<$cantidad;$i++){
        if($i != $posicion){
            $stockProductos[]=$productos[$i];
        }
    }
    echo "Producto eliminado \n";
    $productos=$stockProductos;
    return $productos;



}
function recorrerArreglo($arreglo){
    $contador=0;
    foreach ($arreglo as $elemento) {
        $contador++;
    }
    return $contador;
}


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
            echo "aca creamos clientes";
            break;
        case 2:
            echo "los clientes son:";
            break;
        case 3:
            echo "aca eliminamos clientes";
            break;
    }
}
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
    echo "Seleccione 1,2,3 para cargar un producto a su pedido: ";
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
    }else{
        foreach ($pedidos as $pedido){
            echo "CodigoPedido: " .$pedido->getCodigo() ."\n";
            echo "Monto total: " .$pedido->calcularTotal() ."\n";

        }
    }

}