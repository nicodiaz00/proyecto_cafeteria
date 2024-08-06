<?php
include ('Pedido.php');






$p1= new Producto("Cafe",2,"Bebida caliente","infusion");
$p2=new Producto("Media luna",5,"Factura dulce","Panaderia");

function crearPedido()
{
    $pedido1=Pedido::crear();
    return $pedido1;
}

$pipin = crearPedido();

$pipin->setListaProducto($p1);
$pipin->setListaProducto($p2);

echo $pipin->getListaProducto();
echo $pipin->calcularTotal() ."\n";
echo $pipin->getMontoTotal() ."\n";
echo $pipin->getCodigo()."\n";
