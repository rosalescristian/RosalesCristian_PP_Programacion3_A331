<?php

require_once './Producto.php';
require_once './Producto.php';

class TiendaController {

    public function insertarProducto($nombre, $precio, $tipo, $marca, $stock, $imagen) {

        
    }

    public function modificarCd($id, $titulo, $cantante, $anio) {
        $cd = new Cd();
        $cd->id = $id;
        $cd->titulo = $titulo;
        $cd->cantante = $cantante;
        $cd->año = $anio;
        return $cd->ModificarCdParametros();
    }

    public function borrarCd($id) {
        $cd = new Cd();
        $cd->id = $id;
        return $cd->BorrarCd();
    }

    public function listarCds() {
        return cd::TraerTodoLosCds();
    }

    public function buscarCdPorId($id) {
        $retorno = Cd::TraerUnCd($id);
        if($retorno === false) { // Validamos que exista y si no mostramos un error
            $retorno =  ['error' => 'No existe ese id'];
        }
        return $retorno;
    }

    public function buscarCdPorIdYAnio($id, $anio) {
        return Cd::TraerUnCdAnioParamNombre($id, $anio);
    }
}