<?php
/*
Gestiona todas las operaciones CRUD de productos.
También recibe el campo 'imagen' URL del formulario.
*/

session_start();

require_once "../configuration/conexion.php";
require_once "../models/producto.php";

$modelo = new Producto();

//  ELIMINAR
// Recibe el ID del producto por GET y lo elimina de la BD
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $modelo->EliminarProducto($conexion, $_GET['id']);
    header('Location: ../controllers/productoController.php');
    exit();

// EDITAR
// Recibe todos los datos actualizados del producto por POST
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $modelo->EditarProducto(
        $conexion, $_POST['id'], $_POST['nombre'], $_POST['talla'],
        $_POST['color'], $_POST['marca'], $_POST['precio'], $_POST['stock'],
        $_POST['id_categoria'],
        $_POST['imagen'] ?? '' // Si no envían imagen, cadena vacía
    );
    header('Location: ../controllers/productoController.php');
    exit();

// GUARDAR NUEVO
// Inserta el nuevo producto con todos sus campos incluyendo imagen
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo->GuardarProducto(
        $conexion, $_POST['nombre'], $_POST['talla'], $_POST['color'],
        $_POST['marca'], $_POST['precio'], $_POST['stock'],
        $_POST['id_categoria'],
        $_POST['imagen'] ?? '' // Campo opcional: URL de imagen
    );
    header('Location: ../controllers/productoController.php');
    exit();

// MOSTRAR CARDS 
// Carga productos con JOIN de categoría y las categorías para el select
} else {
    $productos  = $modelo->MostrarProductos($conexion);  // Para las cards
    $categorias = $modelo->MostrarCategorias($conexion); // Para el <select>
    require_once "../views/productos.php";
}
?>
