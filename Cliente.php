<?php
class Cliente{
    private $dni;
    private $nombre;

    private $saldo;
    private $pedidos =[];

    function __construct($dni,$nombre)
    {
        $this->dni=$dni;
        $this->nombre=$nombre;
        $this->saldo=0;
    }
    public function setNombre($nombre){
        $this->nombre=$nombre;
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












}