<?php
require_once("Clases/Cliente.php");
require_once('Helper/Helper.php');
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
            $cliente->mostrarPedidos() . "\n";
            echo "---------------------\n";
        }

        echo "Presione enter para continuar\n";
        trim(fgets(STDIN));
    }
    public function eliminarCliente()
    {
        echo "Ingrese dni: \n";
        $dni = trim(fgets(STDIN));
        if (Helper::valorNumerico($dni)) {
            $clienteEncontrado = false;
            for ($i = 0; $i < count($this->listaClientes); $i++) {
                if ($this->listaClientes[$i]->getDni() === $dni) {
                    unset($this->listaClientes[$i]);
                    $this->listaClientes = array_values($this->listaClientes);
                    echo "\033[32mCliente eliminado con exito\033[0m\n";
                    $clienteEncontrado = true;
                    break;
                }
            }
            if (!$clienteEncontrado) {
                echo "Cliente no registrado\n";
            }
        } else {
            echo "Ingrese solo valores numéricos\n";
        }
    }

    public function clienteExiste($dni)
    {
        foreach ($this->listaClientes as $cliente) {
            if ($cliente->getDni() === $dni) {
                return $cliente;
            }
        }
        return null;
    }
    
    private function cargarSaldo()
    {
        echo "Ingrese dni:  \n";
        $dni = trim(fgets(STDIN));
        if ($cliente = $this->clienteExiste($dni)) {
            echo "Ingrese el saldo a cargar: \n";
            $saldo = trim(fgets(STDIN));
            if (Helper::valorNumerico($saldo)) {
                $cliente->setSaldo($saldo);
                echo "\033[32m Saldo cargado\033[0m\n";
            } else {
                echo "\033[1;31m Solo valores enteros !\033[0m\n";
            }
        } else {
            echo "Cliente no existe\n";
        }
    }
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
    }
    private function cargarClientes($arregloClientes)
    {
        foreach ($arregloClientes as $arregloCliente) {
            $clienteAux = new Cliente();
            $clienteAux->setNombre($arregloCliente['nombre']);
            $clienteAux->setDni($arregloCliente['dni']);
            $clienteAux->setSaldo($arregloCliente['saldo']);

            $clienteAux->cargarPedidos($arregloCliente['pedidos']);
            $this->listaClientes[] = $clienteAux;
        }
    }
    private function nuevoCliente($dni, $nombre)
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
                return true;
            }
        }
        return false;
    }
    public function registrarCliente()
    {
        echo "Ingrese dni:  \n";

        $dniCliente = trim(fgets(STDIN));

        if (Helper::valorNumerico($dniCliente)) {
            if (!$this->validarCliente($dniCliente)) {
                echo "Ingrese su nombre \n";
                $nombreCliente = trim(fgets(STDIN));

                if (Helper::soloAlfabetico($nombreCliente)) {
                    $clienteNuevo = $this->nuevoCliente($dniCliente, $nombreCliente);
                    $this->listaClientes[] = $clienteNuevo;
                    echo "\033[32m Registrado con éxito\033[0m\n";
                } else {
                    echo "\033[1;31m solo caracteres alfabeticos A...Z\033[0m\n";
                }
            } else {
                echo "\033[1;31m Ya estas registrado\033[0m\n";
            }
        } else {
            echo "\033[1;31m El Dni solo debe contener numeros...\033[0m\n";
        }
    }
    private function saldoDisponible($dniCliente)
    {
        for ($i = 0; $i < count($this->listaClientes); $i++) {
            if ($this->listaClientes[$i]->getDni() == $dniCliente)
                echo "Saldo disponible: " . $this->listaClientes[$i]->getSaldo() . "\n";
        }
    }

    public function gestionarCuentaCliente()
    {
        echo "Ingrese dni:  \n";
        $dniCliente = trim(fgets(STDIN));
        $cliente = $this->clienteExiste($dniCliente);
        if ($cliente != null) {
            while (true) {
                echo "0- Volver \n";
                echo "1- Cargar saldo \n";
                echo "2- Ver saldo \n";
                echo "3- Ver mis pedidos\n";
                $opcion = trim(fgets(STDIN));
                switch ($opcion) {
                    case 0:
                        return;
                    case 1:
                        $this->cargarSaldo();
                        break;
                    case 2:
                        $this->saldoDisponible($dniCliente);
                        echo "Presione enter para continuar\n";
                        trim(fgets(STDIN));
                        break;
                    case 3:
                        $cliente->mostrarPedidos();
                        echo "Presione enter para continuar\n";
                        trim(fgets(STDIN));
                        break;
                }
            }
        } else {
            echo "\033[1;31m Dni incorrecto...\033[0m\n";
            echo "Presione enter para continuar\n";
            trim(fgets(STDIN));
        }
    }
}
