<?php
 require_once ('Producto.php');
 require_once ('Serializar.php');
class Pedido implements Serializar{

    private $codigoCliente;
    private $montoTotal;
    private $listaProducto=[];

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
    /*
    public function getListaProductos(){
        $productosEnPedido="";
        foreach($this->listaProducto as $producto){
            $productosEnPedido.=$producto->getNombre()."\n";
        }
        return $productosEnPedido;

    }
    */
    public function calcularTotal()
    {
        $total=0;
        foreach ($this->listaProducto as $producto){
            $total= $total + $producto->getPrecio();
        }
        $this->setMontoTotal($total);
        return $total;

    }
    private function serializarListado(){
        $listadoProducto =[];
        foreach($this->listaProducto as $producto){
            $listadoProducto[]=$producto->serialize();
        }
        return $listadoProducto;
    }
    public function serialize(){

        return[
            "codigoCliente"=>$this->codigoCliente,
            "montoTotal"=>$this->montoTotal,
            "listaProducto"=>$this->serializarListado()

        ];
    }
}

