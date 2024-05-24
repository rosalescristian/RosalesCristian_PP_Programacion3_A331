<?php

//Producto.php


class Producto {
    private static $contador = 0;
    public $id;
    public $nombre;
    public $precio;
    public $tipo;
    public $marca;
    public $stock;
    public $imagen;

    public function __construct($id, $nombre, $precio, $tipo, $marca, $stock, $imagen) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->marca = $marca;
        $this->stock = $stock;
        $this->imagen = $imagen;
    }

    public function guardarProductosJSON(){
        $nombreArchivo = './productos.json';
        if(file_exists($nombreArchivo)){
            $productos = json_decode(file_get_contents($nombreArchivo),true);
        }

        $productos[] = [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'precio' => $this->precio,
            'tipo' => $this->tipo,
            'marca' => $this->marca,
            'stock' => $this->stock,
            'imagen' => $this->imagen,
        ];

        file_put_contents($nombreArchivo, json_encode($productos, JSON_PRETTY_PRINT));

        return true;
    }

    public static function obtenerProductosJSON() {
        $nombreArchivo = './productos.json';
        if (file_exists($nombreArchivo)) {
            $productosData = json_decode(file_get_contents($nombreArchivo), true);
            $productos = [];
            
            foreach ($productosData as $producto) {
                $productos[] = new Producto(
                    $producto['id'],
                    $producto['nombre'],
                    $producto['precio'],
                    $producto['tipo'],
                    $producto['marca'],
                    $producto['stock'],
                    $producto['imagen']??''
                );
            }
            return $productos;
        } else {
            return [];
        }
    }

    public static function obtenerProductoPorId($id) {
        $nombreArchivo = './productos.json';
        $productos = self::obtenerProductosJSON();
        foreach ($productos as $producto) {
            if ($producto->id == $id) {
                return $producto;
            }
        }
        return null;
    }

    /* public function guardarUsuarioCSV() {
        $nombreArchivo = './usuarios.csv';
        $archivo = fopen($nombreArchivo, 'a');
        if ($archivo) {
            $data = [
                $this->nombre,
                $this->clave,
                $this->mail
            ];
            fputcsv($archivo, $data);
            fclose($archivo);
            return true;
        } else {
            return false;
        }
    } */

    /* public static function leerUsuariosCSV($nombreArchivo = 'usuarios.csv') {
        $usuarios = [];
        if (($file = fopen($nombreArchivo, 'r')) !== false) {
            while (($data = fgetcsv($file)) !== false) {
                $usuarios[] = new Usuario($data[0], $data[1], $data[2]);
            }
            fclose($file);
            return $usuarios;
        }
        else{
            return "No se pudo leer el archivo.<br>";
        }
        
    } */

    public static function verificarProducto($nombre, $tipo, $marca) {
        $nombreArchivo = 'productos.json';
        $productos = self::obtenerProductosJSON();
        foreach ($productos as $producto) {
            if ($producto->nombre == $nombre) {
                if ($producto->tipo == $tipo) {
                    if($producto->marca == $marca){
                        return 'Existe!';
                    }
                } else {
                    return 'El producto no existe.';
                }
            }
        }
    }
}
