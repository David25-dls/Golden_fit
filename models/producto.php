<?php
/* .
Gestiona el CRUD de productos y la consulta de
categorías para el <select> de los modales.
*/

class Producto {

    /*
    MÉTODO: MostrarProductos()
    FUNCIÓN: Obtiene todos los productos junto con el nombre
    de su categoría usando un LEFT JOIN entre
    las tablas 'producto' y 'categoria'.
    El LEFT JOIN trae el producto aunque no tenga categoría.
    */
    public function MostrarProductos($conexion) {
        $sql = "SELECT p.*, c.Nombre_categoria
                FROM producto p
                LEFT JOIN categoria c ON p.CATEGORIA_ID_categoria = c.ID_categoria
                ORDER BY p.ID_producto ASC";
        return mysqli_query($conexion, $sql);
    }

    /*
    MÉTODO: GuardarProducto()
    FUNCIÓN: Inserta un nuevo producto con todos sus campos,
    incluyendo la URL de imagen y el ID de categoría
    seleccionado en el select del modal.
    */
    public function GuardarProducto($conexion, $nombre, $talla, $color, $marca, $precio, $stock, $id_categoria, $imagen) {
        $sql  = "INSERT INTO producto (Nombre_producto, Talla, Color, Marca, Precio, Stock, CATEGORIA_ID_categoria, imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);
        // "ssssdi ss" → strings, double (precio decimal), integer (stock), integer (id), string (imagen)
        mysqli_stmt_bind_param($stmt, "ssssdiss", $nombre, $talla, $color, $marca, $precio, $stock, $id_categoria, $imagen);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EditarProducto()
    FUNCIÓN: Actualiza todos los campos de un producto existente
    incluyendo la nueva URL de imagen si fue modificada.
    */
    public function EditarProducto($conexion, $id, $nombre, $talla, $color, $marca, $precio, $stock, $id_categoria, $imagen) {
        $sql  = "UPDATE producto SET Nombre_producto=?, Talla=?, Color=?, Marca=?, Precio=?, Stock=?, CATEGORIA_ID_categoria=?, imagen=? WHERE ID_producto=?";
        $stmt = mysqli_prepare($conexion, $sql);
        // El último "i" es el ID del producto en el WHERE
        mysqli_stmt_bind_param($stmt, "ssssdissi", $nombre, $talla, $color, $marca, $precio, $stock, $id_categoria, $imagen, $id);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: EliminarProducto()
    FUNCIÓN: Elimina un producto de la BD por su ID.
    */
    public function EliminarProducto($conexion, $id) {
        $sql  = "DELETE FROM producto WHERE ID_producto=?";
        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    /*
    MÉTODO: MostrarCategorias()
    FUNCIÓN: Obtiene todas las categorías de la tabla 'categoria'
    ordenadas A-Z para rellenar el <select> de los modales.
    */
    public function MostrarCategorias($conexion) {
        return mysqli_query($conexion, "SELECT * FROM categoria ORDER BY Nombre_categoria ASC");
    }
}
?>
