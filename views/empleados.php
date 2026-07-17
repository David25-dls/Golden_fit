<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados - Golden Fit</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,Helvetica,sans-serif; }
        body { display:flex; background:#f4f4f4; }

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

        .contenido { margin-left:250px; padding:30px; width:100%; }
        .contenido h1 { margin-bottom:20px; color:#1e293b; text-align:center; }

        table { width:95%; border-collapse:collapse; margin:0 auto 20px; }
        th, td { border:1px solid #e2e8f0; padding:12px 10px; text-align:center; }
        th { background:#1e293b; color:white; }
        tr:nth-child(even) { background:#f8fafc; }

        /*
           FUNCIÓN: Muestra el rol del empleado con color diferente.
           Azul para admin, verde para vendedor.
           Permiten identificar visualmente el nivel de acceso.
        */
        .badge-rol   { display:inline-block; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:bold; }
        .badge-admin    { background:#dbeafe; color:#1d4ed8; }
        .badge-vendedor { background:#dcfce7; color:#16a34a; }

        .btn-editamos { padding:6px 14px; background:#3b82f6; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; margin-right:4px; }
        .btn-editamos:hover { background:#2563eb; }
        .btn-eliminar { padding:6px 14px; background:#ef4444; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px; }
        .btn-eliminar:hover { background:#dc2626; }
        .btn-agregar { display:block; width:auto; margin:10px auto; padding:13px 40px; background:linear-gradient(135deg,#334155,#1c2c42); color:white; border:none; border-radius:10px; font-size:16px; font-weight:bold; cursor:pointer; transition:0.3s; }
        .btn-agregar:hover { transform:translateY(-2px); box-shadow:0 5px 12px rgba(0,0,0,0.2); }

        .modal-fondo { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center; }
        .modal-fondo.activo { display:flex; }
        .modal { background:white; border-radius:12px; padding:30px; width:430px; box-shadow:0 10px 30px rgba(0,0,0,0.3); max-height:90vh; overflow-y:auto; }
        .modal h2 { color:#1e293b; margin-bottom:20px; text-align:center; }
        .modal input, .modal select { width:100%; padding:10px 14px; margin-bottom:13px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; }
        /* Fila de dos campos lado a lado */
        .form-fila { display:flex; gap:10px; }
        .form-fila input { flex:1; }
        /* Texto de ayuda en gris debajo del campo de contraseña */
        .hint { font-size:11px; color:#94a3b8; margin-top:-10px; margin-bottom:13px; }
        .modal-botones { display:flex; gap:10px; justify-content:center; margin-top:6px; }
        .btn-guardar { padding:10px 28px; background:#1e293b; color:white; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
        .btn-cancelar{ padding:10px 28px; background:#e2e8f0; color:#1e293b; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
    </style>
</head>
<body>

<?php 
//session_start(); ?>

<!-- SIDEBAR con botón dinámico según sesión -->
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
            <a href="../controllers/LoginController.php?accion=logout" class="btn-cerrar-sesion">Cerrar Sesión</a>
        <?php else: ?>
            <a href="../views/index.php" class="btn-sesion">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</div>

<div class="contenido">
    <h1>NUESTROS EMPLEADOS</h1>

    <!-- 
         TABLA DE EMPLEADOS
         FUNCIÓN: Recorre el resultado $empleados del controller.
         Cada fila muestra los datos del empleado y un badge
         de color según su rol. No se muestra la contraseña
         por seguridad (solo se puede cambiar al editar).
    -->
    <table>
        <tr>
            <th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th>
            <th>Teléfono</th><th>Rol</th><th>Usuario</th><th>Acciones</th>
        </tr>
        <?php while ($fila = mysqli_fetch_assoc($empleados)): ?>
        <tr>
            <td><?php echo htmlspecialchars($fila['ID_empleado']); ?></td>
            <td><?php echo htmlspecialchars($fila['Nombre']); ?></td>
            <td><?php echo htmlspecialchars($fila['Apellido']); ?></td>
            <td><?php echo htmlspecialchars($fila['DNI']); ?></td>
            <td><?php echo htmlspecialchars($fila['Telefono']); ?></td>
            <td>
                <!-- el subrayado cambia de color según el rol del empleado -->
                <?php $clase = ($fila['Rol'] === 'admin') ? 'badge-admin' : 'badge-vendedor'; ?>
                <span class="badge-rol <?php echo $clase; ?>">
                    <?php echo htmlspecialchars($fila['Rol']); ?>
                </span>
            </td>
            <td><?php echo htmlspecialchars($fila['Usuario']); ?></td>
            <td>
                <!-- Al editar NO pasamos la clave por seguridad, se deja en blanco -->
                <button class="btn-editamos" onclick="abrirEditar(
                    '<?php echo $fila['ID_empleado']; ?>',
                    '<?php echo addslashes($fila['Nombre']); ?>',
                    '<?php echo addslashes($fila['Apellido']); ?>',
                    '<?php echo addslashes($fila['DNI']); ?>',
                    '<?php echo addslashes($fila['Telefono']); ?>',
                    '<?php echo addslashes($fila['Rol']); ?>',
                    '<?php echo addslashes($fila['Usuario']); ?>'
                )">Editar</button>
                <button class="btn-eliminar" onclick="eliminar('<?php echo $fila['ID_empleado']; ?>')">Eliminar</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <button class="btn-agregar" onclick="abrirModal()">AGREGAR EMPLEADO</button>
</div>

<!-- Modal Agregar Empleado -->
<div class="modal-fondo" id="modalAgregar">
    <div class="modal">
        <h2>AGREGAR EMPLEADO</h2>
        <form method="POST" action="../controllers/empleadoController.php">
            <!-- Dos campos en la misma fila usando flexbox -->
            <div class="form-fila">
                <input type="text" name="nombre"   placeholder="Nombre"   required>
                <input type="text" name="apellido" placeholder="Apellido" required>
            </div>
            <input type="text"     name="dni"      placeholder="DNI (8 dígitos)"       maxlength="8" required>
            <input type="text"     name="telefono" placeholder="Teléfono"              required>
            <!-- Select de rol: solo admin o vendedor -->
            <select name="rol" required>
                <option value="">Selecciona rol </option>
                <option value="admin">Admin</option>
                <option value="vendedor">Vendedor</option>
            </select>
            <input type="text"     name="usuario"  placeholder="Usuario (para el login)" required>
            <input type="password" name="clave"    placeholder="Contraseña"             required>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">GUARDAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Empleado -->
<div class="modal-fondo" id="modalEditar">
    <div class="modal">
        <h2>EDITAR EMPLEADO</h2>
        <form method="POST" action="../controllers/empleadoController.php">
            <input type="hidden" name="accion"   value="editar">
            <input type="hidden" name="id"       id="edit-id">
            <div class="form-fila">
                <input type="text" name="nombre"   id="edit-nombre"   placeholder="Nombre"   required>
                <input type="text" name="apellido" id="edit-apellido" placeholder="Apellido" required>
            </div>
            <input type="text"     name="dni"      id="edit-dni"      placeholder="DNI"      maxlength="8" required>
            <input type="text"     name="telefono" id="edit-telefono" placeholder="Teléfono" required>
            <select name="rol" id="edit-rol" required>
                <option value="">Selecciona rol </option>
                <option value="admin">Admin</option>
                <option value="vendedor">Vendedor</option>
            </select>
            <input type="text"     name="usuario"  id="edit-usuario"  placeholder="Usuario"  required>
            <!-- Si se deja vacío el modelo NO sobreescribe la contraseña actual -->
            <input type="password" name="clave"    id="edit-clave"    placeholder="Nueva contraseña (dejar vacío para no cambiar)">
            <p class="hint">* Deja la contraseña en blanco si no deseas modificarla.</p>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">ACTUALIZAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarEditar()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModal()  { document.getElementById('modalAgregar').classList.add('activo'); }
    function cerrarModal() { document.getElementById('modalAgregar').classList.remove('activo'); }

    // Carga los datos del empleado en el modal de edición
    // La contraseña NO se pasa por seguridad, queda vacía
    function abrirEditar(id, nombre, apellido, dni, telefono, rol, usuario) {
        document.getElementById('edit-id').value       = id;
        document.getElementById('edit-nombre').value   = nombre;
        document.getElementById('edit-apellido').value = apellido;
        document.getElementById('edit-dni').value      = dni;
        document.getElementById('edit-telefono').value = telefono;
        document.getElementById('edit-rol').value      = rol;
        document.getElementById('edit-usuario').value  = usuario;
        document.getElementById('edit-clave').value    = ''; // Campo en blanco por seguridad
        document.getElementById('modalEditar').classList.add('activo');
    }
    function cerrarEditar() { document.getElementById('modalEditar').classList.remove('activo'); }

    function eliminar(id) {
        if (confirm('¿Estás seguro de eliminar este empleado?')) {
            window.location.href = '../controllers/empleadoController.php?accion=eliminar&id=' + id;
        }
    }

    document.getElementById('modalAgregar').addEventListener('click', function(e) { if(e.target===this) cerrarModal(); });
    document.getElementById('modalEditar').addEventListener('click',  function(e) { if(e.target===this) cerrarEditar(); });
</script>
</body>
</html>
