<?php
/*
Gestiona el CRUD completo del personal de la tienda.
Incluye lógica especial para no borrar contraseñas.
*/

class Empleado {

    /*
    MÉTODO: MostrarEmpleados()
    FUNCIÓN: Obtiene todos los empleados ordenados por ID
    para mostrarlos en la tabla de la vista.
    */
    public function MostrarEmpleados($conexion) {
        return mysqli_query($conexion, "SELECT * FROM empleado ORDER BY ID_empleado ASC");
    }

    /*
    MÉTODO: GuardarEmpleado()
    FUNCIÓN: Inserta un nuevo empleado con sus datos personales,
             su rol (admin o vendedor), usuario y contraseña
             que usará para iniciar sesión en el sistema.
    */
    public function GuardarEmpleado($conexion, $nombre, $apellido, $dni, $telefono, $rol, $usuario, $clave) {
        $sql  = "INSERT INTO empleado (Nombre, Apellido, DNI, Telefono, Rol, Usuario, Clave) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        // "sssssss" = los 7 campos son tipo string (texto)
        mysqli_stmt_bind_param($stmt, "sssssss", $nombre, $apellido, $dni, $telefono, $rol, $usuario, $clave);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EditarEmpleado()
    FUNCIÓN: Actualiza los datos del empleado.
    */
    // FUNCIÓN: Actualiza los datos del empleado.
    //          LÓGICA ESPECIAL DE CONTRASEÑA:
    //          Si el campo clave llega VACÍO desde el formulario,
    //          ejecuta UPDATE sin tocar la contraseña actual.
    //          Si llega CON VALOR, actualiza también la contraseña.
    //          Esto evita borrar la clave por accidente al editar.
    // ----------------------------------------------------------
    public function EditarEmpleado($conexion, $id, $nombre, $apellido, $dni, $telefono, $rol, $usuario, $clave) {
        if (!empty($clave)) {
            // CASO 1: Nueva contraseña enviada → actualizamos TODOS los campos
            $sql  = "UPDATE empleado SET Nombre=?, Apellido=?, DNI=?, Telefono=?, Rol=?, Usuario=?, Clave=? WHERE ID_empleado=?";
            $stmt = mysqli_prepare($conexion, $sql);
            // "sssssssi" = 7 strings y 1 integer para el ID del WHERE
            mysqli_stmt_bind_param($stmt, "sssssssi", $nombre, $apellido, $dni, $telefono, $rol, $usuario, $clave, $id);
        } else {
            // CASO 2: Campo clave vacío → actualizamos TODO excepto la contraseña
            $sql  = "UPDATE empleado SET Nombre=?, Apellido=?, DNI=?, Telefono=?, Rol=?, Usuario=? WHERE ID_empleado=?";
            $stmt = mysqli_prepare($conexion, $sql);
            // "ssssssi" = 6 strings y 1 integer para el ID del WHERE
            mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apellido, $dni, $telefono, $rol, $usuario, $id);
        }
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EliminarEmpleado()
    FUNCIÓN: Elimina un empleado de la BD por su ID.
    */
    public function EliminarEmpleado($conexion, $id) {
        $sql  = "DELETE FROM empleado WHERE ID_empleado=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }
}
?>
