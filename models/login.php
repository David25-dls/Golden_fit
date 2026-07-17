<?php
/*
Contiene la lógica que verifica las credenciales
del empleado directamente contra la base de datos.
*/

class Login {

    /*
    MÉTODO: VerificarLogin()
    FUNCIÓN: Busca en la tabla 'empleado' un registro que
    coincida exactamente con el usuario y clave enviados.
    Retorna los datos del empleado si existe,
    o false si las credenciales son incorrectas.
    */
    public function VerificarLogin($conexion, $usuario, $clave) {

        // Consulta SQL: busca el empleado por usuario Y clave
        // LIMIT 1 porque solo necesitamos saber si existe uno
        $sql = "SELECT * FROM empleado WHERE Usuario = ? AND Clave = ? LIMIT 1";

        // Preparamos la consulta para evitar inyección SQL
        // Los (?) son parámetros que se llenan de forma segura
        $stmt = mysqli_prepare($conexion, $sql);

        // Vinculamos los valores reales a los parámetros (?)
        // "ss" indica que ambos son tipo string (texto)
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $clave);

        // Ejecutamos la consulta preparada
        mysqli_stmt_execute($stmt);

        // Obtenemos el resultado de la consulta
        $resultado = mysqli_stmt_get_result($stmt);

        // Intentamos leer la fila del empleado como array asociativo
        $fila = mysqli_fetch_assoc($resultado);

        // Si encontró al empleado retorna sus datos, si no retorna false
        return $fila ?: false;
    }
}
?>
