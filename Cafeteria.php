
<?php
//archivo main donde ejecutamos la cafeteria.

require ('Cliente.php');
require ('Producto.php');
//arreglos que contendran clientes, productos y pedidos al ejecutar el sistema.
$clientes =[];
$productos =[];
$pedidos =[];
function menuBievendida(){
    cargarProductos();
    $mostrarMenu=true;
    while(true){
        if($mostrarMenu){
            echo "Bienvenido a cafeteria 1.0\n";
            echo "Seleccione una opcion: \n";
            echo "0 -Salir\n";
            echo "1- Gestion cliente\n"; //aca tenemos que poder crear, listar y eliminar cliente
            echo "2- Gestion producto\n";//aca tenemos que poder mostrar un producto, agregar un producto o sacar un producto del stock
            echo "3- Gestion pedidos \n"; // aca tenemos que poder crear un pedido, listar los pedidos o eliminar un pedido.
        }


        $opcion = trim(fgets(STDIN));
        switch ($opcion){
            case 0:
                salida();
                exit();
            case 1:
                gestionCliente();

                break;
            case 2:
                mostrarProducto();
                break;
        }
    }
}
function salida(){
    echo "Hasta luego";
}
function cargarProductos(){
    global $productos;
    $producto1=new Producto("Cafe",3,"Cafe Mediano","Bebida");
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
}
function cargarProducto($producto){ //funcion para ingresar productos al stock de la cafeteria
    global $productos;
    $productos[]=$producto;
}
function crearProducto(){ //funcion para crear un nuevo producto a la cafeteria
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
}
function eliminarProducto()
{

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




menuBievendida();



