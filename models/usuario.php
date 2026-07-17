<?php
/*
Contiene la clase Cliente con los 4 métodos CRUD:
Create → GuardarCliente()
Read   → MostrarCliente()
Update → EditarCliente()
Delete → EliminarCliente()
Todos usan prepared statements para seguridad SQL.
*/

class Cliente {

    /*
    MÉTODO: MostrarCliente()
    FUNCIÓN: Obtiene todos los registros de la tabla 'cliente'.
    Devuelve el resultado para que la vista lo recorra
    con while y muestre cada fila en la tabla HTML.
    */
    public function MostrarCliente($conexion) {
        $sql = "SELECT * FROM cliente";
        return mysqli_query($conexion, $sql);
    }

    /*
    MÉTODO: GuardarCliente()
    FUNCIÓN: Inserta un nuevo cliente en la tabla 'cliente'.
    Los datos vienen del formulario del modal de agregar.
    */
    public function GuardarCliente($conexion, $nombre, $direccion, $correo, $telefono) {
        $sql  = "INSERT INTO cliente (Nombre_cliente, Direccion, Correo, Telefono) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        // "ssss" = los 4 parámetros son tipo string (texto)
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $direccion, $correo, $telefono);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EditarCliente()
    FUNCIÓN: Actualiza los datos de un cliente existente.
    El WHERE ID_cliente=? asegura que solo se
    modifique ese cliente específico por su ID.
    */
    public function EditarCliente($conexion, $id, $nombre, $direccion, $correo, $telefono) {
        $sql  = "UPDATE cliente SET Nombre_cliente=?, Direccion=?, Correo=?, Telefono=? WHERE ID_cliente=?";
        $stmt = mysqli_prepare($conexion, $sql);
        // "ssssi" = 4 strings y 1 integer (el ID del WHERE)
        mysqli_stmt_bind_param($stmt, "ssssi", $nombre, $direccion, $correo, $telefono, $id);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EliminarCliente()
    FUNCIÓN: Elimina un cliente de la BD por su ID.
    El WHERE evita borrar registros equivocados.
    */
    public function EliminarCliente($conexion, $id) {
        $sql  = "DELETE FROM cliente WHERE ID_cliente=?";
        $stmt = mysqli_prepare($conexion, $sql);
        // "i" = el parámetro ID es tipo integer (número entero)
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }
}
?>
