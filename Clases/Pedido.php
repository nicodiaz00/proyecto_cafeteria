<?php
 require_once ('Producto.php');
 require_once ('Serializar.php');
class Pedido implements Serializar{
    private static $cantidadPedidos=0;
    private $codigoCliente;
    private $montoTotal;
    private $listaProducto=[];
    private $id;

    static function crearPedido()
    {
        $pedido = new Pedido();
        Pedido::$cantidadPedidos= Pedido::$cantidadPedidos + 1;
        $pedido->setId(Pedido::$cantidadPedidos);
        return $pedido;

    }
    public static function setCantidadPedidos($cantidadPedidos){
        self::$cantidadPedidos=$cantidadPedidos;
    }
    public function getId(){
        return $this->id;
    }
    public function setId($idPedido){
        $this->id=$idPedido;
    }
    public function setCodigoCliente($cod){
        $this->codigoCliente=$cod;
    }
    public function getCodigoCliente(){
        return $this->codigoCliente;
    }
    public function setMontoTotal($montoTotal){
        $this->montoTotal=$this->montoTotal+$montoTotal;
    }
    public function getMontoTotal(){
        return $this->montoTotal;
    }
    public function setListaProducto($producto){
        $this->listaProducto[]=$producto;
    }
    public function getListaProducto() {
        return $this->listaProducto;
    }
    
    public function cargarProductos($arreglodeProducto){
        foreach ($arreglodeProducto as $producto){
            $productoAux=new Producto($producto['Nombre'],$producto['Precio'], $producto['Descripcion'], $producto['Tipo']);
            $this->listaProducto[]=$productoAux;
        }
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
            "id"=>$this->getId(),
            "codigoCliente"=>$this->getCodigoCliente(),
            "montoTotal"=>$this->getMontoTotal(),
            "listaProducto"=>$this->serializarListado()
        ];
    }
}

