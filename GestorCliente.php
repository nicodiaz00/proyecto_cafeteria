<?php
require_once ("Cliente.php");

class GestorCliente
{
    public $listaClientes = [];
    private $clientesJson = "Json/Clientes.json";

    public function __construct()
    {
        $arregloCliente = $this->leerJson($this->clientesJson);
        $this->cargarClientes($arregloCliente);
    }

    public function listarClientes()
    {
        echo "Lista de clientes: \n";
        foreach ($this->listaClientes as $cliente) {
            echo "Nombre: " . $cliente->getNombre() . "\n";
            echo "Dni: " . $cliente->getDni() . "\n";
            echo "----------\n";
        }
        echo "Presione enter para continuar\n";
        trim(fgets(STDIN));
    }

    public function crearCliente()
    {
        echo "Ingrese su  nombre \n";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese DNI: \n";
        $dni = trim(fgets(STDIN));

        $cliente = new Cliente();
        $cliente->setNombre($nombre);
        $cliente->setDni($dni);
        $this->listaClientes[] = $cliente;
        echo "\033[32mregistrado con éxito\033[0m\n";

    }

    public function eliminarCliente()
    {
        $posicion = -1;
        $arregloClientes = [];
        echo "Ingrese dni: \n";
        $dni = fgets(STDIN);
        for ($i = 0; $i < count($this->listaClientes); $i++) {
            if ($this->listaClientes[$i]->getDni() == $dni) {
                $posicion = $i;
                break;
            }
        }
        if ($posicion == -1) {
            echo "cliente no existe\n";
        } else {
            for ($i = 0; $i < count($this->listaClientes); $i++) {
                if ($i != $posicion) {
                    $arregloClientes[] = $this->listaClientes[$i];
                }
            }
            $this->listaClientes = $arregloClientes;
            echo "Cliente eliminado\n";
        }
    }

    private function clienteExiste($dni)
    {
        for ($i = 0; $i < count($this->listaClientes); $i++) {
            if ($this->listaClientes[$i]->getDni() == $dni) {
                return $this->listaClientes[$i];
            }
        }
        return false;
    }

    public function cargarSaldo()
    {
        echo "Ingrese dni:  \n";
        $dni = fgets(STDIN);
        if ($cliente = $this->clienteExiste($dni)) {
            echo "Ingrese el saldo a cargar: \n";
            $saldo = trim(fgets(STDIN));
            $cliente->setSaldo($saldo);
            echo "Saldo cargado... \n";
        } else {
            echo "Cliente no existe\n";
        }

    }

    //metodos para leer el json, crear el arreglo de cliente y guardar el arreglo de clientes en el json:

    private function leerJson($archivoJson)
    {
        $arregloDeClientes = json_decode(file_get_contents($archivoJson), true);
        return $arregloDeClientes;
    }

    private function objetosClientesToJson($arregloObjetos)
    {
        $arregloAsociativo = [];
        foreach ($arregloObjetos as $cliente) {
            $arregloAsociativo[] = $cliente->serialize();
        }
        $arregloJson = json_encode($arregloAsociativo, JSON_PRETTY_PRINT);
        return $arregloJson;
    }

    private function guardarClientes()
    {
        $json = $this->objetosClientesToJson($this->listaClientes);
        file_put_contents($this->clientesJson, $json);
    }

    public function cerrarGestorCiente()
    {
        $this->guardarClientes();
        echo "gestor cerrado, info guardada...\n";
    }

    private function cargarClientes($arregloClientes)
    {
        foreach ($arregloClientes as $arregloCliente) {
            $clienteAux = new Cliente();
            $clienteAux->setNombre($arregloCliente['nombre']);
            $clienteAux->setDni($arregloCliente['dni']);
            $clienteAux->setSaldo($arregloCliente['saldo']);
            $clienteAux->setPedidos($arregloCliente['pedidos']);
            $this->listaClientes[] = $clienteAux;
        }

    }

    public function nuevoCliente($dni, $nombre)
    {
        $nuevoCliente = new Cliente();
        $nuevoCliente->setNombre($nombre);
        $nuevoCliente->setDni($dni);
        return $nuevoCliente;

    }
    private function validarCliente($dni)
    {
        for ($i = 0; $i < count($this->listaClientes); $i++) {
            if ($this->listaClientes[$i]->getDni() == $dni) {
                return true;  // Cliente ya está registrado
            }
        }
        return false;  // Cliente no encontrado
    }

    public function registrarCliente(){
        echo "Ingrese dni:  \n";
        $dniCliente = trim(fgets(STDIN));
        if(!$this->validarCliente($dniCliente)){
            echo "Ingrese su nombre \n";
            $nombreCliente =trim(fgets(STDIN));
            $clienteNuevo=$this->nuevoCliente($dniCliente, $nombreCliente);
            $this->listaClientes[] = $clienteNuevo;
            echo "\033[32m Registrado con éxito\033[0m\n";
        }else{
            echo "\033[1;31m Ya estas registrado\033[0m\n";
        }


    }
}







