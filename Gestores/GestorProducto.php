<?php
require_once ("Clases/Producto.php");
class GestorProducto{
    private $listaProductos =[];
    private $archivoJson = "Json/Productos.json";
    public function __construct(){
        $arregloAsociativo=$this->leerJson($this->archivoJson);
        $this->cargarStock($arregloAsociativo);
    }
    public function listarProductos()
    {
        foreach ($this->listaProductos as $producto) {
            echo "Nombre: " .$producto->getNombre() .", Precio: " .$producto->getPrecio().", Descripcion: ".$producto->getDescripcion().", Tipo: ".$producto->getTipo()."\n";
            echo "--------------------------------- \n";
        }
        echo "Presione ENTER para continuar...\n";
        readline();
    }
    public function agregarProducto(Producto $producto){
        $this->listaProductos[] = $producto;
        echo "Producto cargado al sistema\n";
    }
    public function crearProducto(){
        echo"---------\n";
        echo "Ingrese nombre producto: \n";
        $nombre =trim(fgets(STDIN));
        echo "Ingrese precio: \n";
        $precio = trim(fgets(STDIN));
        echo "Ingrese descripcion: \n";
        $descripcion = trim(fgets(STDIN));
        echo "Ingrese tipo: 'bebida' o 'sandwich' \n";
        $tipo=trim(fgets(STDIN));

        echo "Producto creado \n";
        return $producto = new Producto($nombre,$precio,$descripcion,$tipo);
    }
    public function eliminarProducto(){
        $posicion = -1;
        $nuevoStock =[];
        echo "Ingrese nombre del producto a eliminar \n";
        $nombreProducto = trim(fgets(STDIN));
        for($i=0;$i<count($this->listaProductos);$i++){
            if($this->listaProductos[$i]->getNombre() == $nombreProducto){
                $posicion = $i;
                break;
            }
        }
        if($posicion == -1){
            echo "Producto no encontrado \n";
            echo "Presione ENTER para continuar...\n";
            readline();
        }else{
            for($x=0;$x<count($this->listaProductos);$x++){
                if($x!=$posicion){
                    $nuevoStock[] = $this->listaProductos[$x];
                }
            }
            $this->listaProductos=$nuevoStock;
            echo "Producto eliminado y stock actualizado \n";
            echo "Presione ENTER para continuar...\n";
            readline();
        }
    }
    public function cargarProducto(){
        $product = $this->crearProducto();
        $this->agregarProducto($product);
    }
    private function cargarStock($arreglo){
        foreach ($arreglo as $pr) {
            $productoAux = new Producto($pr['Nombre'],$pr['Precio'], $pr['Descripcion'], $pr['Tipo']);
            $this->listaProductos[] = $productoAux;
        }
    }
    //parte de lectura y convertir json
    private function leerJson($archivoJson){
        $array = json_decode(file_get_contents($archivoJson),true);
        return $array;
    }
    private function objetosToJson($arregloDeobjetos){
        $arrayAsociativo = [];
        foreach ($arregloDeobjetos as $producto) {
            $arrayAsociativo[]=$producto->serialize();
        }
        $json= json_encode($arrayAsociativo,JSON_PRETTY_PRINT);
        return  $json;
    }
    private function guardarInfo(){
        $json= $this->objetosToJson($this->listaProductos);
        file_put_contents($this->archivoJson,$json);
    }
    public function cerrarGestorProducto(){
        $this->guardarInfo();
    }
    public function getListaProductos(){
        return $this->listaProductos;
    }
    public function elegirProducto($valor){

        if ($valor > 0 && $valor <= count($this->listaProductos)) {
            $producto = $this->listaProductos[$valor - 1]; // resto uno para coincidir con indice del arreglo
            return $producto;
        } else {
            return "Producto invalido"; /*null;*/
        }
    }
}