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
                $pedido->setListaProducto($producto);
            }
            //$pedido->setListaProducto($producto);

            $this->pedidos[] = $pedido;
        }

    }
    //busco tomar los pedidos que estan el arreglo y llevarlo al json para guardar esa informacion

    //falta terminar:
    public function crearPedido() {
        echo "Ingrese DNI: ";
        $dni = trim(fgets(STDIN));
        $pedidoAux = new Pedido();
        $pedidoAux->setCodigoCliente($dni);

        echo "Presione 1 para comenzar a agregar productos:\n";
        $opcion = trim(fgets(STDIN));

        while ($opcion != 0) {
            $this->mostrarCarta();
            echo "Seleccione un producto (1,2,3...) para agregar a su pedido, o 0 para finalizar:\n";
            $opcion = trim(fgets(STDIN));


            if ($opcion == 0) {
                break; // Finaliza el bucle si elige 0
            }

            $productoSeleccionado = $this->gestorProducto->elegirProducto($opcion);

                $pedidoAux->setListaProducto($productoSeleccionado);
                $pedidoAux->setMontoTotal($productoSeleccionado->getPrecio()); // Suma el precio al monto total
                echo "Producto agregado \n";

        }

        $this->pedidos[] = $pedidoAux; // Agrega el pedido a la lista
        echo "Su pedido ha sido creado, ¡gracias!\n";
    }

    public function listarPedidos(){
        echo "Pedidos: \n";
        foreach ($this->pedidos as $pedido) {

            echo "Codigo: " .$pedido->getCodigoCliente() ." ,Monto: ".$pedido->getMontoTotal()."\n";
            echo "Productos: \n";
            foreach ($pedido->getListaProducto() as $producto) {
                echo $producto->getNombre() ."\n";
            }
            echo "--------\n";

        }
        echo "Presione enter para continuar\n";
        trim(fgets(STDIN));
    }
    private function mostrarCarta()
    {
        $productosAux = $this->gestorProducto->getListaProductos();
        for ($i = 0; $i < count($productosAux); $i++) {
            echo $i+1 ."Nombre: " .$productosAux[$i]->getNombre() ." ,Precio: " .$productosAux[$i]->getPrecio() ." \n";
            echo "---------\n";
        }
    }





}