<?php
require_once ("Cliente.php");

class GestorCliente
{
    private $jsonClientes="Json/Clientes.json";
    public $listaClientes = [];
    private $clientesJson = "Json/clientes.json";
    public function __construct()
    {

    }
    public function listarClientes(){
        foreach ($this->listaClientes as $cliente){

            echo "Nombre: " .$cliente->getNombre() .", " ."Dni: " . $cliente->getDni() ."\n";
            echo "----------\n";
        }
    }
    public function crearCliente(){
        echo "Ingrese nombre: \n";
        $nombre=fgets(STDIN);
        echo "Ingrese DNI: \n";
        $dni=fgets(STDIN);

        $cliente = new Cliente();
        $cliente->setNombre($nombre);
        $cliente->setDni($dni);
        $this->listaClientes[] = $cliente;
    }
    public function eliminarCliente(){
        $posicion =-1;
        $arregloClientes =[];
        echo "Ingrese dni: \n";
        $dni=fgets(STDIN);
        for($i = 0; $i < count($this->listaClientes); $i++){
            if($this->listaClientes[$i]->getDni() == $dni){
                $posicion = $i;
                break;
            }
        }
        if($posicion == -1){
            echo "cliente no existe\n";
        }else{
            for($i = 0; $i < count($this->listaClientes); $i++){
                if($i != $posicion){
                    $arregloClientes[]= $this->listaClientes[$i];
                }
            }
            $this->listaClientes = $arregloClientes;
            echo "Cliente eliminado\n";
        }
    }

    private function clienteExiste($dni){
        for($i = 0; $i < count($this->listaClientes); $i++){
            if($this->listaClientes[$i]->getDni() == $dni){
                return $this->listaClientes[$i];
            }
        }
        return false;
    }
    public function cargarSaldo(){
        echo "Ingrese dni:  \n";
        $dni=fgets(STDIN);
        if($cliente= $this->clienteExiste($dni)){
            echo "Ingrese el saldo a cargar: \n";
            $saldo=trim(fgets(STDIN));
            $cliente->setSaldo($saldo);
            echo"Saldo cargado... \n";
        }else{
            echo "Cliente no existe\n";
        }

    }





}