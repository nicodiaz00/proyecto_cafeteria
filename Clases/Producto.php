<?php
require_once ("Serializar.php");
class Producto implements serializar {
    private $nombre;
    private $precio;
    private $descripcion;
    private $tipo;

    function __construct($nombre, $precio, $descripcion, $tipo){
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
    }
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function setTipo($tipo){
        $this->tipo = $tipo;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function getTipo(){
        return $this->tipo;
    }

    public function serialize(){
        return[
            "Nombre"=>$this->nombre,
            "Precio"=>$this->precio,
            "Descripcion"=>$this->descripcion,
            "Tipo"=>$this->tipo
        ];
    }

}