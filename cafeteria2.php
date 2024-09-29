<?php
require_once ("Gestor.php");

function menuBievendida(){
    $gestion = new Gestor();

    while(true){

        echo "Bienvenido a cafeteria 2.0\n";
        echo "Seleccione una opcion: \n";
        echo "0 -Salir\n";
        echo "1- Gestion cliente\n";
        echo "2- Gestion producto\n";
        echo "3- Gestion pedidos \n";

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