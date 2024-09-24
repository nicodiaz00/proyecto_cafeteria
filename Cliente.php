<?php
require_once("Pedido.php");
class Cliente{

    private $nombre;
    private $dni;
    private $saldo;
    private $pedidos =[];

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













}