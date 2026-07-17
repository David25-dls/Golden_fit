<?php
/*
Recibe peticiones GET y POST, decide qué operación
ejecutar y llama al método del modelo correspondiente.
*/


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../configuration/conexion.php";
require_once "../models/usuario.php";

// Instanciamos la clase Cliente del modelo para usar sus métodos
$modelo = new Cliente();

// ELIMINAR
// URL: usuarioController.php?accion=eliminar&id=X
// El ID llega por GET desde el onclick del botón eliminar
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $modelo->EliminarCliente($conexion, $_GET['id']);
    // Redirigimos para refrescar la lista después de eliminar
    header('Location: ../controllers/usuarioController.php');
    exit();

// EDITAR
// Los datos llegan por POST desde el modal de edición
// El campo hidden 'accion=editar' identifica esta operación
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $modelo->EditarCliente($conexion, $_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['correo'], $_POST['telefono']);
    header('Location: ../controllers/usuarioController.php');
    exit();

// GUARDAR NUEVO
// Los datos llegan por POST desde el modal de agregar
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo->GuardarCliente($conexion, $_POST['nombre'], $_POST['direccion'], $_POST['correo'], $_POST['telefono']);
    header('Location: ../controllers/usuarioController.php');
    exit();

// MOSTRAR LISTA
// Carga todos los clientes y los pasa a la vista para mostrar la tabla
} else {
    $cliente = $modelo->MostrarCliente($conexion);
    require_once "../views/cliente.php";
}
?>
