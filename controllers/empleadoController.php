<?php
/*
Gestiona el CRUD completo del personal de la tienda.
*/

session_start();

require_once "../configuration/conexion.php";
require_once "../models/empleado.php";

$modelo = new Empleado();

//ELIMINAR
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $modelo->EliminarEmpleado($conexion, $_GET['id']);
    header('Location: ../controllers/empleadoController.php');
    exit();

//EDITAR
// Si la clave viene vacía, el modelo no sobreescribe la contraseña actual
} elseif (isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $modelo->EditarEmpleado(
        $conexion, $_POST['id'], $_POST['nombre'], $_POST['apellido'],
        $_POST['dni'], $_POST['telefono'], $_POST['rol'],
        $_POST['usuario'], $_POST['clave'] // Puede venir vacío, el modelo lo maneja
    );
    header('Location: ../controllers/empleadoController.php');
    exit();

//GUARDAR
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $modelo->GuardarEmpleado(
        $conexion, $_POST['nombre'], $_POST['apellido'], $_POST['dni'],
        $_POST['telefono'], $_POST['rol'], $_POST['usuario'], $_POST['clave']
    );
    header('Location: ../controllers/empleadoController.php');
    exit();

//MOSTRAR TABLA DE EMPLEADOS
} else {
    $empleados = $modelo->MostrarEmpleados($conexion);
    require_once "../views/empleados.php";
}
?>
