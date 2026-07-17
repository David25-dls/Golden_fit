<?php
/*
ARCHIVO: configuration/conexion.php
FUNCIÓN: Establece la conexión con la base de datos MySQL.
Este archivo es requerido por todos los controllers
para poder ejecutar consultas a la BD golden_fit.
*/

$servidor = "localhost";   // Servidor donde corre MySQL (en XAMPP es localhost)
$usuario  = "root";        // Usuario de MySQL (por defecto en XAMPP es root)
$password = "";            // Contraseña de MySQL (vacía en XAMPP local)
$dbname   = "golden_fit";  // Nombre de la base de datos del proyecto

// Creamos la conexión usando mysqli_connect()
// Devuelve un objeto de conexión que usaremos en todos los controllers
$conexion = mysqli_connect($servidor, $usuario, $password, $dbname);

// Si la conexión falla, detenemos todo y mostramos el error
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
