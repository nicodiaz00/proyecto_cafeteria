<?php
require_once ("Pedido.php");
require_once ("GestorCliente.php");
require_once ("GestorProducto.php");
class GestorPedido
{
    public $pedidos = [];
    private $jsonPedidos = "Json/Pedidos.json";
    private $gestorProducto;
    private $gestorCliente;

    public function __construct()
    {
        $this->gestorProducto = new GestorProducto();
        $this->gestorCliente = new GestorCliente();
        $this->cargarArregloPedidos($this->jsonPedidos);
    }

    //tomar la lectura del json para cargar datos:
    private function cargarArregloPedidos($infoJson)
    {
        $arregloAsociativo = $this->leerDatos($infoJson);
        $this->cargarPedidos($arregloAsociativo);
    }

    private function leerDatos($archivoJson)
    {
        $arregloPedidos = json_decode(file_get_contents($archivoJson), true);
        return $arregloPedidos;
    }

    private function cargarPedidos($arreglo)
    {
        for ($i = 0; $i < count($arreglo); $i++) {
            $pedido = new Pedido();
            $pedido->setCodigoCliente($arreglo[$i]['codigoCliente']);
            $pedido->setMontoTotal($arreglo[$i]['montoTotal']);

            $listaProducto = [];
            for ($x = 0; $x < count($arreglo[$i]['listaProducto']); $x++) {
                $producto = new Producto($arreglo[$i]['listaProducto'][$x]['Nombre'],
                    $arreglo[$i]['listaProducto'][$x]['Precio'],
                    $arreglo[$i]['listaProducto'][$x]['Descripcion'],
                    $arreglo[$i]['listaProducto'][$x]['Tipo']);
                $listaProducto[] = $producto;
            }
            $pedido->setListaProducto($listaProducto);

            $this->pedidos[] = $pedido;
        }
    }
    //busco tomar los pedidos que estan el arreglo y llevarlo al json para guardar esa informacion

    //falta terminar:
    public function crearPedido()
    {
        $productos = $this->gestorProducto->getListaProductos();
        $opcion = -1;
        echo "ingrese dni: ";
        $dni = trim(fgets(STDIN));
        $pedidoAux = new Pedido();
        $pedidoAux->setCodigoCliente($dni);

        //echo "Ingrese 1 para comenzar a agregar productos a su pedido:\n";

        while ($opcion != 0) {
            echo " Carta: \n";
            for ($i = 0; $i < count($productos); $i++) {
                echo $i+1 ." -Nombre: " . $productos[$i]->getNombre() ." Precio: " .$productos[$i]->getPrecio()."\n";
                echo "---------- \n";
            }
            echo "Ingrese 1, 2, 3 ...para elegir el producto o cero para finalizar\n";
            $opcion= trim(fgets(STDIN));
//falta cerrar pedido

        }


    }

}