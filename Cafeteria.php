
<?php
//archivo main donde ejecutamos la cafeteria.
require_once('Gestion.php');



function menuBievendida(){
    cargarSistema("Json/productos.json");
    $mostrarMenu=true;
    while(true){
        //if($mostrarMenu){
            echo "Bienvenido a cafeteria 1.0\n";
            echo "Seleccione una opcion: \n";
            echo "0 -Salir\n";
            echo "1- Gestion cliente\n"; //aca tenemos que poder crear, listar y eliminar cliente
            echo "2- Gestion producto\n";//aca tenemos que poder mostrar un producto, agregar un producto o sacar un producto del stock
            echo "3- Gestion pedidos \n"; // aca tenemos que poder crear un pedido, listar los pedidos o eliminar un pedido.

        $opcion = trim(fgets(STDIN));
        switch ($opcion){
            case 0:
                guardarProducto("Json/Productos.json");
                exit();
            case 1:
                gestionCliente();

                break;
            case 2:
                gestionProducto();

                break;
            case 3:
                gestionPedido();
        }
    }
}
menuBievendida();





