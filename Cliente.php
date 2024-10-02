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
    public function registrarPedido(Pedido $pedido){
        $this->pedidos[]=$pedido;
    }

    public function setPedidos($pedidos){
        $this->pedidos=$pedidos;
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