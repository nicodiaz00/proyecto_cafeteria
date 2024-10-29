<?php
require_once('Pedido.php');
require_once('Serializar.php');
class Cliente implements Serializar{

    private $nombre;
    private $dni;
    private $saldo;
    private $pedidos =[];

    public function __construct(){

        $this->setSaldo(0);
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDni($dni){
        $this->dni=$dni;
    }
    public function setSaldo($saldo){
        $this->saldo=$this->saldo + $saldo;
    }
    public function actualizarSaldo($saldo){
        $this->saldo = $saldo;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getSaldo(){
        return $this->saldo;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function registrarPedido($pedido){
        $this->pedidos[]=$pedido;
    }
    public function retirarPedido($pedidoId){
        for($i=0;$i<count($this->pedidos);$i++){
            if($this->pedidos[$i]->getId()==$pedidoId){
                unset($this->pedidos[$i]);
                break;

            }
        }
        $this->pedidos = array_values($this->pedidos);
    }
    public function getPedidos()
    {
        return $this->pedidos;
    }
    public function mostrarPedidos()
    {
        foreach ($this->pedidos as $pedido) {
            echo " ---- \n";
            echo "Pedido: \n";
            echo "Id:" .$pedido->getId() ."\n";
            echo "Codigo:" .$pedido->getCodigoCliente() ."\n";
            echo "Monto:" .$pedido->getMontoTotal() ."\n";
            echo "Productos:\n";
            foreach ($pedido->getListaproducto() as $producto) {
                echo $producto->getNombre() ."\n";
            }
        }
    }
    public function cargarPedidos($arregloPedidos){
        foreach ($arregloPedidos as $pedido) {
            $pedidoAux =new Pedido();
            $pedidoAux->setiD($pedido['id']);  // intento traer el id dl pdido del json
            $pedidoAux->setCodigoCliente($pedido['codigoCliente']);
            $pedidoAux->setMontoTotal($pedido['montoTotal']);
            $pedidoAux->cargarProductos($pedido['listaProducto']);
            $this->pedidos[]=$pedidoAux;
        }
    }
    public function serialize() {
        $pedidosSerializados = [];
        foreach ($this->pedidos as $pedido) {
            $pedidosSerializados[] = $pedido->serialize();
        }
        return [
            "nombre" => $this->nombre,
            "dni" => $this->dni,
            "saldo" => $this->saldo,
            "pedidos" => $pedidosSerializados
        ];
    }













}