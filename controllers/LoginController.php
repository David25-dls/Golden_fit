<?php
/*
Maneja 3 acciones:
1 LOGOUT   cierra la sesión y redirige al login
2 POST     verifica credenciales y abre sesión
3 DEFAULT  muestra el formulario de login
*/

// session_start SIEMPRE al inicio, antes de cualquier salida HTML
// Permite crear, leer y destruir variables de sesión PHP
session_start();

require_once "../configuration/conexion.php";
require_once "../models/login.php";

$modelo      = new Login();
$error_login = ""; // Almacena el mensaje de error para mostrarlo en la vista

/*ACCIÓN: CERRAR SESIÓN
Se activa cuando el usuario presiona "Cerrar Sesión" en el sidebar
La URL llega como: LoginController.php?accion=logout*/
if (isset($_GET['accion']) && $_GET['accion'] === 'logout') {

    // Borramos todas las variables guardadas en $_SESSION
    session_unset();

    // Destruimos completamente la sesión PHP del servidor
    session_destroy();

    // Redirigimos de vuelta al login después de cerrar sesión
    header('Location: ../controllers/LoginController.php');
    exit(); // Detenemos la ejecución después del redirect
}

//ACCIÓN: VERIFICAR LOGIN
// Se activa cuando el usuario envía el formulario método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recogemos los campos del formulario
    // trim() elimina espacios en blanco al inicio y al final
    $usuario = trim($_POST['usuario'] ?? '');
    $clave   = trim($_POST['clave']   ?? '');

    // Validamos que los campos no estén vacíos
    if ($usuario === '' || $clave === '') {
        $error_login = "Por favor completa todos los campos.";
    } else {

        // Llamamos al modelo para verificar contra la tabla 'empleado'
        // Retorna los datos del empleado si existe, o false si no
        $empleado = $modelo->VerificarLogin($conexion, $usuario, $clave);

        if ($empleado) {
            // Login correcto guarda datos en la sesión PHP
            // Estas variables estarán disponibles en TODAS las páginas
            $_SESSION['empleado_id']     = $empleado['ID_empleado'];
            $_SESSION['empleado_nombre'] = $empleado['Nombre'] . ' ' . $empleado['Apellido'];
            $_SESSION['empleado_rol']    = $empleado['Rol'];
            $_SESSION['logueado']        = true;

            // Redirigimos al panel de inicio del sistema
            header('Location: ../views/vistaUsuario.php');
            exit();
        } else {
            // Datos incorrectos guardamos el mensaje de error
            // La vista lo mostrará en el cuadro rojo de alerta
            $error_login = "Usuario o contraseña incorrectos.";
        }
    }
}

/*ACCIÓN: MOSTRAR FORMULARIO 
Si no hay POST o hubo un error → mostramos la vista del login
La variable $error_login estará disponible en index.php*/
require_once "../views/index.php";
?>
