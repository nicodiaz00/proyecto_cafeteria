<?php
require_once("Pedido.php");
class Cliente{
    private static $cantidad=0;

    private $id;
    private $nombre;
    private $apellido;
    private $dni;
    private $saldo;
    private $pedidos =[];

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setApellido($apellido){
        $this->apellido=$apellido;
    }

    public function setDni($dni){
        $this->dni=$dni;
    }
    public function setSaldo($saldo){
        $this->saldo=$saldo;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDni(){
        return $this->dni;
    }
    public function getSaldo(){
        return $this->dni;
    }

    public function setId($id)
    {
        $this->id=$id;
    }
    public static function crearCliente(){
        $cliente = new Cliente();
        Cliente::$cantidad=Cliente::$cantidad+1;
        $cliente->setId(Cliente::$cantidad);
        return $cliente;
    }
    public function registrarPedido(Pedido $pedido){
        $this->pedidos[]=$pedido;
    }













}