<?php

// TiendaAlta.php

Class TiendaAlta {
 
public function insertarProducto($nombre, $precio, $tipo, $marca, $stock, $imagen) {
    $tiendaJson = file_get_contents('./tienda.json');
    $tienda = json_decode($tiendaJson, true);
    $producto = new Producto($id = count($tienda) + 1, $nombre, $precio, $tipo, $marca, $stock, $imagen);
    $productoExistente = false;

    foreach ($tienda as &$producto) {
        if ($producto['nombre'] === $nombre && $producto['marca'] === $marca) {
            // Actualizar precio y sumar al stock existente
            $producto['precio'] = $precio;
            $producto['stock'] += $stock;
            $productoExistente = true;
            break;
        }
    }

    // Si el producto no existe, agregarlo al archivo
    if (!$productoExistente) {
        $productoNuevo = [
            'id' => count($tienda) + 1,
            'nombre' => $nombre,
            'precio' => $precio,
            'tipo' => $tipo,
            'marca' => $marca,
            'stock' => $stock,
            'imagen' => $imagen
        ];
        $tienda[] = $productoNuevo;
    }

    file_put_contents('./tienda.json', json_encode($tienda));

    }
}