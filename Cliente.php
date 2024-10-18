<?php
require_once("Pedido.php");
require_once("Serializar.php");
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
        $this->saldo=$saldo;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getSaldo(){
        return $this->dni;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function registrarPedido($pedido){
        $this->pedidos[]=$pedido;
    }
    /*
    public function getpedidos()
    {
        foreach ($this->pedidos as $pedido) {
            echo "Codigo:" .$pedido->getCodigoCliente() ."\n";
            echo "Monto:" .$pedido->getMontoTotal() ."\n";
            echo "Productos:\n";
            foreach ($pedido->getListaproducto() as $producto) {
                echo $producto->getNombre() ."\n";
            }
            echo "------------------\n";
        }
    }
    */
    public function getPedidos() {
        $resultado = "";
        foreach ($this->pedidos as $pedido) {
            $resultado .= "Codigo: " . $pedido->getCodigoCliente() . "\n";
            $resultado .= "Monto: " . $pedido->getMontoTotal() . "\n";
            $resultado .= "Productos:\n";
            foreach ($pedido->getListaProducto() as $producto) {
                $resultado .= $producto->getNombre() . "\n";
            }
            $resultado .= "------------------\n";
        }
        return $resultado; // Devuelve todos los pedidos como una cadena
    }
    public function cargarPedidos($arregloPedidos){
        foreach ($arregloPedidos as $pedido) {
            $pedidoAux =new Pedido();
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