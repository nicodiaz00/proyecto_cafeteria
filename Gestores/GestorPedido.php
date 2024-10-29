<?php
require_once ("Clases/Pedido.php");
require_once ("GestorCliente.php");
require_once ("GestorProducto.php");
class GestorPedido
{
    public $pedidos = [];
    private $jsonPedidos = "Json/pedidos.json";
    private $gestorProducto;
    private $gestorCliente;

    public function __construct($clienteGestion,$productoGestion)
    {
        $this->gestorProducto = $productoGestion;
        $this->gestorCliente = $clienteGestion;
        $this->cargarArregloPedidos($this->jsonPedidos);
    }
    //tomar la lectura del json para cargar datos:
    private function cargarArregloPedidos($infoJson)
    {
        $arregloAsociativo = $this->leerDatos($infoJson);
        $this->cargarPedidos($arregloAsociativo);
    }
    private function leerDatos($archivoJson)
    {
        $arregloPedidos = json_decode(file_get_contents($archivoJson), true);
        return $arregloPedidos;
    }
    private function encontrarPedido($codigoPedido){
        foreach ($this->pedidos as $pedido) {

            if ($pedido->getCodigoCliente() === $codigoPedido) {
                echo "Código del pedido: " . $codigoPedido . "\n";
                return $pedido;
            }
        }
        return null;
    }
    private function cargarPedidos($arreglo)
    {
        for ($i = 0; $i < count($arreglo); $i++) {
            $pedido = new Pedido();
            $pedido->setId($arreglo[$i]['id']);
            $ultimoID = $arreglo[$i]['id'];
            Pedido::setCantidadPedidos($ultimoID);
            $pedido->setCodigoCliente($arreglo[$i]['codigoCliente']);
            $pedido->setMontoTotal($arreglo[$i]['montoTotal']);

            for ($x = 0; $x < count($arreglo[$i]['listaProducto']); $x++) {
                $producto = new Producto($arreglo[$i]['listaProducto'][$x]['Nombre'],
                    $arreglo[$i]['listaProducto'][$x]['Precio'],
                    $arreglo[$i]['listaProducto'][$x]['Descripcion'],
                    $arreglo[$i]['listaProducto'][$x]['Tipo']);
                $pedido->setListaProducto($producto);
            }
            $this->pedidos[] = $pedido;
        }
    }
    public function registrarPedido(){
        echo "Ingrese su dni\n";
        $dniCliente = trim(fgets(STDIN));

        $cliente=$this->gestorCliente->clienteExiste($dniCliente);
        if($cliente){

            $pedidoAux=$this->nuevoPedido($cliente->getDni());
            $cliente->registrarPedido($pedidoAux);
        }else{
            echo "\033[1;31m No estas registrado\033[0m\n";
            echo "Presione enter para continuar\n";
            trim(fgets(STDIN));
        }
    }
    private function nuevoPedido($dniCliente){
        $pedidoAux = Pedido::crearPedido();
        $pedidoAux->setCodigoCliente($dniCliente);
        echo "Presione 1 para comenzar a agregar productos:\n";
        $opcion = trim(fgets(STDIN));

        while ($opcion != 0) {
            $this->mostrarCarta();
            echo "Seleccione un producto (1,2,3...) para agregar a su pedido, o 0 para finalizar:\n";
            $opcion = trim(fgets(STDIN));

            if ($opcion == 0) {
                break; // Finaliza el bucle si elige 0
            }else{
                $productoSeleccionado = $this->gestorProducto->elegirProducto($opcion);
                $pedidoAux->setListaProducto($productoSeleccionado);
                $pedidoAux->setMontoTotal($productoSeleccionado->getPrecio()); // Suma el precio al monto total
                echo "\033[32mProducto Agregado...\033[0m\n";
            }
        }
        echo "\033[32mSu pedido ha sido creado, ¡gracias!\033[0m\n";
        $this->pedidos[] = $pedidoAux;
        return $pedidoAux;
    }
    public function listarPedidos(){
        echo "Pedidos: \n";
        foreach ($this->pedidos as $pedido) {

            echo "Codigo: " .$pedido->getCodigoCliente() ." ,Monto: ".$pedido->getMontoTotal() .", ID: ".$pedido->getId() ."\n";
            echo "Productos: \n";
            foreach ($pedido->getListaProducto() as $producto) {
                echo $producto->getNombre() ."\n";
            }
            echo "--------\n";
        }
        echo "Presione enter para continuar\n";
        trim(fgets(STDIN));
    }
    private function mostrarCarta()
    {
        $productosAux = $this->gestorProducto->getListaProductos();
        $contador =0;
        foreach ($productosAux as $producto) {
            $contador ++;
            echo $contador ." - " .$producto->getNombre() ." ,Precio: " .$producto->getPrecio() ." \n";
            echo "---------\n";
        }
    }
    private function realizarCobro($saldoCliente,$saldoPedido){
        if($saldoCliente >= $saldoPedido){
            $saldoFinal= $saldoCliente - $saldoPedido;
            return $saldoFinal;
        }else{
            return "Saldo insuficiente para realizar cobro\n";
        }
    }
    public function entregarPedido(){
        echo "Ingrese DNI para retirar el pedido:\n";
        $dniCliente = trim(fgets(STDIN));
        $cliente = $this->gestorCliente->clienteExiste($dniCliente);

        if ($cliente != null) {
            $pedidos = $cliente->getPedidos();

            if (count($pedidos) > 0) {

                $cliente->mostrarPedidos();
                echo "Seleccione el ID del pedido:\n";
                $pedidoId = trim(fgets(STDIN));
                $pedido = $this->encontrarPedidoPorId($pedidoId);

                if ($pedido !=null && $pedido->getCodigoCliente() === $dniCliente) {
                    $valorTotal = $pedido->getMontoTotal();

                    if($cliente->getSaldo() >= $valorTotal){
                        $saldoFinal = $this->realizarCobro($cliente->getSaldo(), $valorTotal);
                        $cliente->actualizarSaldo($saldoFinal);
                        $cliente->retirarPedido($pedidoId);
                        $this->eliminarPedido($pedidoId);

                        echo "Pedido ID:" .$pedidoId ."entregado con éxito.\n";
                    } else {
                        echo "\033[1;31mSaldo insuficiente\033[0m\n";
                    }
                } else {
                    echo "El pedido no pertenece al cliente.\n";
                }
            } else {
                echo "No tienes pedidos en tu cuenta.\n";
            }
        } else {
            echo "Cliente no registrado.\n";
        }
    }
    private function eliminarPedido($pedidoId){
        for($i=0;$i<count($this->pedidos);$i++){
            if($this->pedidos[$i]->getId()==$pedidoId){
                unset($this->pedidos[$i]);
                break;
            }
        }
        $this->pedidos = array_values($this->pedidos);
    }
    private function encontrarPedidoporId($id){
        foreach ($this->pedidos as $pedido) {
            if($pedido->getId() == $id){
                return $pedido;
            }
        }
        return null;
    }
    private function PedidosToJson($arregloPedidos){
        $arregloDePedidos=[];
        foreach ($arregloPedidos as $pedido) {
            $arregloDePedidos[]=$pedido->serialize();
        }
        return json_encode($arregloDePedidos,JSON_PRETTY_PRINT);
    }
    private function guardarPedidos(){
        $json=$this->PedidosToJson($this->pedidos);
        file_put_contents($this->jsonPedidos,$json);
    }
    public function cerrarGestorPedido(){
        $this->guardarPedidos();
    }
}