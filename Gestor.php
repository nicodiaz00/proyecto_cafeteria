<?php
require_once ("GestorProducto.php");
require_once ("GestorCliente.php");
require_once ("GestorPedido.php");

Class Gestor{

    private $gestionProducto;
    private $gestionCliente;
    private $gestionPedidos;

    public function __construct(){
        $this->gestionProducto = new GestorProducto();
        $this->gestionCliente = new GestorCliente();
        $this->gestionPedidos = new GestorPedido($this->gestionCliente, $this->gestionProducto);

    }
    public function menuAdministrador(){
        while(true){
            echo "Seleccione opcion deseada: \n";
            echo "0- VOLVER \n ";
            echo "1- Listar clientes \n ";
            echo "2- Eliminar cliente \n ";
            echo "3- Agregar Productos \n ";
            echo "4- Eliminar producto \n ";
            echo "5- Ver pedidos \n ";

            $opcion = trim(fgets(STDIN));

            switch($opcion){
                case "0":
                    return;
                case "1":
                    $this->gestionCliente->listarClientes();
                    break;
                case "2":
                    $this->gestionCliente->eliminarCliente();
                    break;
                case "3":
                    $this->gestionProducto->cargarProducto();
                    break;
                case "4":
                    $this->gestionProducto->eliminarProducto();
                    break;
                case "5":
                    $this->gestionPedidos->listarPedidos();
                    break;

            }
        }

    }
    public function menuCliente(){
        while(true){
            echo "Seleccione opcion deseada: \n";
            echo "0- Volver \n ";
            echo "1- Ver carta \n ";
            echo "2- Registrarse \n ";
            echo "3- Crear pedido \n ";
            echo "4- Cargar saldo \n ";


            $seleccion = trim(fgets(STDIN));

            switch($seleccion){
                case "0":
                    return;
                case "1":
                    $this->gestionProducto->listarProductos();
                    break;
                case "2":
                    $this->gestionCliente->registrarCliente();
                    break;
                case "3":
                    $this->gestionPedidos->crearPedido();
                    break;
                case "4":
                    $this->gestionCliente->cargarSaldo();

            }
        }
    }

    public function menuBienvenida(){
        while(true){

            echo "Bienvenido a cafeteria 2.0\n";
            echo "Seleccione una opcion: \n";
            echo "0 -Salir\n";
            echo "1- Menu cliente\n";
            echo "2- Menu Administrador\n";

            $opcion = trim(fgets(STDIN));
            switch ($opcion){
                case 0:
                    $this->gestionCliente->cerrarGestorCiente();
                    $this->gestionProducto->cerrarGestor();
                    exit();
                case 1:
                    $this->menuCliente();
                    break;
                case 2:
                    $this->menuAdministrador();
                    break;

            }
        }
    }
}

