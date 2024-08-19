<?php

require_once ("Producto.php");

$productito = new Producto("Pancho",19,"pancho rico","sandwich");

$variable=json_encode($productito);

echo $variable;




