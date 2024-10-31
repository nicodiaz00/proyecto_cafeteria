<?php
require_once("Clases/Producto.php");
class GestorProducto
{
    private $listaProductos = [];
    private $archivoJson = "Json/Productos.json";
    public function __construct()
    {
        $arregloAsociativo = $this->leerJson($this->archivoJson);
        $this->cargarStock($arregloAsociativo);
    }
    public function listarProductos()
    {
        foreach ($this->listaProductos as $producto) {
            echo "Nombre: " . $producto->getNombre() . ", Precio: " . $producto->getPrecio() . ", Descripcion: " . $producto->getDescripcion() . ", Tipo: " . $producto->getTipo() . "\n";
            echo "--------------------------------- \n";
        }
        echo "Presione ENTER para continuar...\n";
        readline();
    }
    private function agregarProducto(Producto $producto)
    {
        $this->listaProductos[] = $producto;
        
    }
    public function registrarProducto(){
        echo "---------\n";
        echo "Ingrese nombre producto: \n";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese precio: \n";
        $precio = trim(fgets(STDIN));
        echo "Ingrese descripcion: \n";
        $descripcion = trim(fgets(STDIN));
        echo "Ingrese tipo: 'bebida' o 'sandwich' \n";
        $tipo = trim(fgets(STDIN));

        $nuevoProducto = $this->nuevoProducto($nombre,$precio,$descripcion,$tipo);

        $this->agregarProducto($nuevoProducto);

        echo "Producto cargado al sistema\n";
    }
    private function nuevoProducto($nombre,$precio,$descripcion,$tipo){
        
        $producto = new Producto($nombre, $precio, $descripcion, $tipo);

        return $producto;
    }
    private function reorganizarListaProductos(){
        $this->listaProductos = array_values($this->listaProductos);
    }
    private function encontrarProducto($nombre){
        $posicion = -1;
        for($i = 0;$i < count($this->listaProductos);$i++){
            if($nombre == $this->listaProductos[$i]->getNombre()){
                $posicion = $i;
                break;
            }
        }
        return $posicion;
    }

    public function eliminarProducto(){
        echo "Ingrese nombre del producto a eliminar \n";
        $nombreProducto = trim(fgets(STDIN));

        $posicionProducto = $this->encontrarProducto($nombreProducto);

        if($posicionProducto != -1){
            $this->quitarProductoLista($posicionProducto);
            $this->reorganizarListaProductos();

            echo "\033[0;32mProducto eliminado y stock actualizado\033[0m \n";
            echo "Presione ENTER para continuar...\n";
            trim(fgets(STDIN));
        }else{
            echo "\033[0;31mProducto no encontrado\033[0m \n";
            echo "Presione ENTER para continuar...\n";
        }

    }
    private function quitarProductoLista($posicion){
        unset($this->listaProductos[$posicion]);
    }
  
    private function cargarStock($arreglo)
    {
        foreach ($arreglo as $pr) {
            
            $productoAux = $this->nuevoProducto($pr['Nombre'], $pr['Precio'], $pr['Descripcion'], $pr['Tipo']);
            $this->agregarProducto($productoAux);   
        }
    }
    
    private function leerJson($archivoJson)
    {
        $array = json_decode(file_get_contents($archivoJson), true);
        return $array;
    }
    private function objetosToJson($arregloDeobjetos)
    {
        $arrayAsociativo = [];
        foreach ($arregloDeobjetos as $producto) {
            $arrayAsociativo[] = $producto->serialize();
        }
        $json = json_encode($arrayAsociativo, JSON_PRETTY_PRINT);
        return  $json;
    }
    private function guardarInfo()
    {
        $json = $this->objetosToJson($this->listaProductos);
        file_put_contents($this->archivoJson, $json);
    }
    public function cerrarGestorProducto()
    {
        $this->guardarInfo();
    }
    public function getListaProductos()
    {
        return $this->listaProductos;
    }
    
    public function elegirProducto($valor)
    {

        if ($valor > 0 && $valor <= count($this->listaProductos)) {
            $producto = $this->listaProductos[$valor - 1];
            return $producto;
        } else {
            return  null;
        }
        
    }
}
