<?php
/*
session_start SIEMPRE debe ser la PRIMERA línea del archivo
ANTES de cualquier HTML, espacio o comentario.
FUNCIÓN: Inicia la sesión PHP para leer $_SESSION y saber
si el empleado ya inició sesión y mostrar el botón correcto.
*/
//session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Golden Fit</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,Helvetica,sans-serif; }
        body { display:flex; background:#f4f4f4; }
 
        /* Sidebar idéntico en todas las vistas para consistencia visual */
        .sidebar { width:250px; height:100vh; background:#1e293b; padding-top:20px; position:fixed; display:flex; flex-direction:column; }
        .sidebar h2 { color:white; text-align:center; margin-bottom:30px; }
        .sidebar nav { flex:1; }
        .sidebar ul { list-style:none; }
        .sidebar ul li { margin:10px 0; }
        .sidebar ul li a { display:block; color:white; text-decoration:none; padding:15px 20px; transition:0.3s; }
        .sidebar ul li a:hover { background:#334155; padding-left:30px; }
        .sidebar-footer { padding:20px; border-top:1px solid #334155; }
        .btn-cerrar-sesion { display:block; width:100%; padding:12px; background:#ef4444; color:white; border:none; border-radius:8px; font-size:14px; text-align:center; text-decoration:none; cursor:pointer; transition:0.3s; }
        .btn-cerrar-sesion:hover { background:#dc2626; }
        .btn-sesion { display:block; width:100%; padding:12px; background:transparent; color:#94a3b8; border:1px solid #334155; border-radius:8px; font-size:14px; text-align:center; text-decoration:none; transition:0.3s; }
        .btn-sesion:hover { background:#334155; color:white; }
 
        /* Contenido desplazado para no quedar detrás del sidebar */
        .contenido { margin-left:250px; padding:30px; width:100%; }
        .contenido h1 { margin-bottom:20px; color:#1e293b; text-align:center; }
 
        /*
           TABLA DE CLIENTES
           FUNCIÓN: Muestra todos los clientes del resultado $cliente
           que viene del controller. nth-child(even) alterna colores
           de fila para facilitar la lectura de la tabla.
        */
        table { width:90%; border-collapse:collapse; margin:0 auto 20px; }
        th, td { border:1px solid #e2e8f0; padding:12px 10px; text-align:center; }
        th { background:#1e293b; color:white; }
        tr:nth-child(even) { background:#f8fafc; }
 
        /* Botón azul de editar */
        .btn-editamos { padding:6px 14px; background:#3b82f6; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; margin-right:4px; }
        .btn-editamos:hover { background:#2563eb; }
        /* Botón rojo de eliminar */
        .btn-eliminar { padding:6px 14px; background:#ef4444; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; }
        .btn-eliminar:hover { background:#dc2626; }
        /* Botón principal para abrir modal de agregar */
        .btn-agregar { display:block; width:auto; margin:10px auto; padding:13px 40px; background:linear-gradient(135deg,#334155,#1c2c42); color:white; border:none; border-radius:10px; font-size:16px; font-weight:bold; cursor:pointer; transition:0.3s; }
        .btn-agregar:hover { transform:translateY(-2px); box-shadow:0 5px 12px rgba(0,0,0,0.2); }
 
        /* 
           MODAL EMERGENTE
           FUNCIÓN: Ventana flotante para agregar/editar clientes.
           Por defecto está oculta con display:none.
           La clase 'activo' la muestra cambiando a display:flex.
           El fondo oscuro semitransparente cubre todo el contenido.
        */
        .modal-fondo { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center; }
        .modal-fondo.activo { display:flex; }
        .modal { background:white; border-radius:12px; padding:30px; width:400px; box-shadow:0 10px 30px rgba(0,0,0,0.3); }
        .modal h2 { color:#1e293b; margin-bottom:20px; text-align:center; }
        .modal input { width:100%; padding:10px; margin-bottom:14px; border:1px solid #ccc; border-radius:8px; font-size:14px; }
        .modal-botones { display:flex; gap:10px; justify-content:center; margin-top:10px; }
        .btn-guardar { padding:10px 28px; background:#1e293b; color:white; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
        .btn-cancelar { padding:10px 28px; background:#e2e8f0; color:#1e293b; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
    </style>
</head>
<body>

<!-- SIDEBAR con botón dinámico según estado de sesión -->
<div class="sidebar">
    <h2>GOLDEN FIT</h2>
    <nav>
        <ul>
            <li><a href="../views/vistaUsuario.php">Inicio</a></li>
            <li><a href="../controllers/usuarioController.php">Clientes</a></li>
            <li><a href="../controllers/productoController.php">Productos</a></li>
            <li><a href="../controllers/empleadoController.php">Empleados</a></li>
        </ul>
    </nav>
    <div class="sidebar-footer">
        <?php if (!empty($_SESSION['logueado'])): ?>
            <!-- ✅ HAY SESIÓN → botón rojo cerrar sesión -->
            <a href="../controllers/LoginController.php?accion=logout" class="btn-cerrar-sesion">Cerrar Sesión</a>
        <?php else: ?>
            <!-- SIN SESIÓN  botón gris iniciar sesión -->
            <a href="../views/index.php" class="btn-sesion">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</div>
 
<div class="contenido">
    <h1>NUESTROS CLIENTES</h1>
 
    <!-- 
         TABLA DE CLIENTES
         FUNCIÓN: Recorre el resultado $cliente del controller
         con while(). Cada iteración genera una fila HTML.
         htmlspecialchars() convierte caracteres especiales a
         entidades HTML para prevenir ataques XSS.
         addslashes() escapa comillas para el onclick de JavaScript.
    -->
    <table>
        <tr>
            <th>ID</th><th>Nombre</th><th>Dirección</th>
            <th>Correo</th><th>Teléfono</th><th>Acciones</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($cliente)): ?>
        <tr>
            <td><?php echo htmlspecialchars($fila['ID_cliente']); ?></td>
            <td><?php echo htmlspecialchars($fila['Nombre_cliente']); ?></td>
            <td><?php echo htmlspecialchars($fila['Direccion']); ?></td>
            <td><?php echo htmlspecialchars($fila['Correo']); ?></td>
            <td><?php echo htmlspecialchars($fila['Telefono']); ?></td>
            <td>
                <!-- Botón editar: llama a abrirEditar() con los datos de esta fila -->
                <button class="btn-editamos" onclick="abrirEditar(
                    '<?php echo $fila['ID_cliente']; ?>',
                    '<?php echo addslashes($fila['Nombre_cliente']); ?>',
                    '<?php echo addslashes($fila['Direccion']); ?>',
                    '<?php echo addslashes($fila['Correo']); ?>',
                    '<?php echo addslashes($fila['Telefono']); ?>'
                )">Editar</button>
                <!-- Botón eliminar: pide confirmación antes de redirigir al controller -->
                <button class="btn-eliminar" onclick="eliminar('<?php echo $fila['ID_cliente']; ?>')">Eliminar</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
 
    <button class="btn-agregar" onclick="abrirModal()">AGREGAR CLIENTE</button>
</div>
 
<!-- 
     MODAL AGREGAR
     FUNCIÓN: Formulario emergente para registrar un nuevo cliente.
     Envía datos por POST al controller (sin campo 'accion')
     para que el controller sepa que es una inserción nueva.
-->
<div class="modal-fondo" id="modalAgregar">
    <div class="modal">
        <h2>AGREGAR CLIENTE</h2>
        <form method="POST" action="../controllers/usuarioController.php">
            <input type="text"  name="nombre"    placeholder="Nombre completo" required>
            <input type="text"  name="direccion" placeholder="Dirección" required>
            <input type="email" name="correo"    placeholder="Correo electrónico" required>
            <input type="text"  name="telefono"  placeholder="Teléfono" required>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">GUARDAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>
 
<!--
     MODAL EDITAR
     FUNCIÓN: Formulario para modificar un cliente existente.
     Los campos hidden 'accion' e 'id' indican al controller
     que es una edición y qué registro actualizar.
     Los campos se precargan con JavaScript (abrirEditar).
-->
<div class="modal-fondo" id="modalEditar">
    <div class="modal">
        <h2>EDITAR CLIENTE</h2>
        <form method="POST" action="../controllers/usuarioController.php">
            <input type="hidden" name="accion" value="editar"> <!-- Indica al controller que es edición -->
            <input type="hidden" name="id"     id="edit-id">   <!-- ID del cliente a actualizar -->
            <input type="text"   name="nombre"    id="edit-nombre"    placeholder="Nombre completo" required>
            <input type="text"   name="direccion" id="edit-direccion" placeholder="Dirección" required>
            <input type="email"  name="correo"    id="edit-correo"    placeholder="Correo electrónico" required>
            <input type="text"   name="telefono"  id="edit-telefono"  placeholder="Teléfono" required>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">ACTUALIZAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarEditar()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>
 
<!-- 
     JAVASCRIPT
     FUNCIÓN: Controla la apertura/cierre de los modales,
     precarga datos en el modal de edición y maneja la
     confirmación antes de eliminar un cliente.
 -->
<script>
    // Abre/cierra el modal de agregar añadiendo o quitando la clase 'activo'
    function abrirModal()  { document.getElementById('modalAgregar').classList.add('activo'); }
    function cerrarModal() { document.getElementById('modalAgregar').classList.remove('activo'); }
 
    // Abre el modal de editar y llena los campos con los datos del cliente seleccionado
    function abrirEditar(id, nombre, direccion, correo, telefono) {
        document.getElementById('edit-id').value        = id;        // ID oculto para el WHERE
        document.getElementById('edit-nombre').value    = nombre;
        document.getElementById('edit-direccion').value = direccion;
        document.getElementById('edit-correo').value    = correo;
        document.getElementById('edit-telefono').value  = telefono;
        document.getElementById('modalEditar').classList.add('activo');
    }
    function cerrarEditar() { document.getElementById('modalEditar').classList.remove('activo'); }
 
    // Muestra confirmación antes de eliminar y redirige al controller con la acción
    function eliminar(id) {
        if (confirm('¿Estás seguro de eliminar este cliente?')) {
            window.location.href = '../controllers/usuarioController.php?accion=eliminar&id=' + id;
        }
    }
 
    // Cierra el modal si el usuario hace clic en el fondo oscuro (fuera del recuadro)
    document.getElementById('modalAgregar').addEventListener('click', function(e) { if(e.target===this) cerrarModal(); });
    document.getElementById('modalEditar').addEventListener('click',  function(e) { if(e.target===this) cerrarEditar(); });
</script>
</body>
</html>