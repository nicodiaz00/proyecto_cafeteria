<?php
require_once ("GestorPedido.php");
require_once ("GestorProducto.php");

$gestionPedidos= new GestorPedido();


$gestionProducto = new GestorProducto();

$gestionPedidos->crearPedido();









