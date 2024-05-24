
<?php

$mail = $_POST['email'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$marca = $_POST['marca'];
$stock = $_POST['stock'];

$productosJson = file_get_contents('productos.json');
$productos = json_decode($productosJson, true);

$ventasJson = file_get_contents('ventas.json');
$ventas = json_decode($ventasJson, true);

$venta = [
    'id' => uniqid(),
    'mail' => $emailUsuario,
    'nombre' => $nombre,
    'tipo' => $tipo,
    'marca' => $marca,
    'stock' => $stock
];
$ventas[] = $venta;
file_put_contents('ventas.json', json_encode($ventas));

echo 'Venta realizada correctamente';
