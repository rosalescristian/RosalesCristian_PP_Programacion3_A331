<?php

/******************************************************************************

ROSALES CRISTIAN A331 // Viernes: 20240524 - 18:30

*******************************************************************************/

/*
Hay recuperatorio al final del cursado, es lo que falte del parcial 1 y la cuarte parte
Hay 2 puntos que valen 2 puntos.
*/

require_once './TiendaAlta.php';
require_once './TiendaController.php';

$tiendaJson = file_get_contents('./tienda.json');
$tienda = json_decode($tiendaJson, true);

// Manejo de solicitudes GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    handleGetRequest();
} 

// Manejo de solicitudes POST
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    handlePostRequest();
} 

// Manejo de solicitudes PUT
elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    handlePutRequest($cdController);
} 

// Manejo de solicitudes DELETE
elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    handleDeleteRequest($cdController);
} 

// Función para manejar solicitudes POST
function handlePostRequest() {
    $tipoValidos = ['Smartphone','Tablet'];
    if (!isset($_GET['action'])) {
        echo json_encode(['error' => 'Falta el parámetro action']);
        return;
    }
    $action = $_GET['action'];
    switch ($action) {
        case 'insertar':
            if(!isset($_POST['nombre']) && isset($_POST['precio']) && ($_POST['precio'] > 0) && 
                isset($_POST['tipo']) && (in_array($_POST['tipo'],$tipoValidos)) && 
                isset($_POST['marca']) && isset($_POST['stock']) && ($_POST['stock'] > 0) && 
                isset($_FILES['imagen'])) {
                    echo json_encode(['error' => 'Faltan parámetros necesarios. Corregir!']);
                    return;
            }

            $id = rand(1, 10000);
            $nombreArchivo = $_FILES['imagen']['name'];;
            $rutaImagen = '/ImagenesDeProductos/2024' . $id . '-' . $_POST['nombre'] . '-' . basename(($nombreArchivo));
            if(!file_exists('/ImagenesDeProductos/2024')){
                mkdir('/ImagenesDeProductos/2024',0777, true);
            }
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
                $producto = new Producto($id, $_POST['nombre'], $_POST['precio'], $_POST['tipo'], $_POST['marca'], $_POST['stock'], $rutaImagen);
                $producto->guardarProductosJSON();
                echo json_encode(['mensaje' => 'Alta realizada correctamente']);
            } else {
                echo json_encode(['error' => 'Error al subir la imagen']);
            }
            break;
        case 'consultar':
            if(!isset($_POST['nombre']) &&
                isset($_POST['tipo']) &&
                isset($_POST['marca'])){
                    echo json_encode(['error' => 'Faltan parámetros necesarios. Corregir!']);
                    return;
                }
            $resultado = Producto::verificarProducto($_POST['nombre'], $_POST['tipo'], $_POST['marca']);
            if ($resultado === 'Existe') {
                    $response = ['status' => 'success', 'message' => 'El producto ya existe'];
                } else {
                    $response = ['status' => 'error', 'message' => 'Error en los datos'];
                }
        case 'altaVenta':
            
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
}