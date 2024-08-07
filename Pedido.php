<?php
 require_once ('Producto.php');
class Pedido{

    private static $cantidad=0;
    private $codigo;
    private $codigoCliente;
    private $montoTotal;
    private $listaProducto=[];



    public function setCodigo($cod){
        $this->codigo=$cod;
    }
    public function getCodigo(){
        return $this->codigo;
    }
    static function crear(){

        $pedido = new Pedido();
        Pedido::$cantidad = Pedido::$cantidad +1;
        $pedido->setCodigo(Pedido::$cantidad);
        return $pedido;
    }
    public function setCodigoCliente($cod){
        $this->codigoCliente=$cod;
    }
    public function getCodigoCliente(){
        return $this->codigoCliente;
    }
    public function setMontoTotal($montoTotal){
        $this->montoTotal=$montoTotal;
    }
    public function getMontoTotal(){
        return $this->montoTotal;
    }
    public function setListaProducto($producto){
        $this->listaProducto[]=$producto;
    }
    public function getListaProducto(){
        foreach($this->listaProducto as $producto){
            echo "Nombre: " .$producto->getNombre() ."\n";
        }
    }
    public function calcularTotal()
    {
        $total=0;
        foreach ($this->listaProducto as $producto){
            $total= $total + $producto->getPrecio();
        }
        $this->setMontoTotal($total);
        return $total;

    }



}

