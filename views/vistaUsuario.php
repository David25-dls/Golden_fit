<?php
/*
session_start() SIEMPRE debe ser la PRIMERA línea del archivo
ANTES de cualquier HTML, espacio o comentario.
FUNCIÓN: Inicia la sesión PHP para leer $_SESSION y saber
si el empleado ya inició sesión en el sistema.
*/
session_start();
 
// Conectamos la BD para los conteos de las cards de resumen
// FUNCIÓN: Incluye el archivo de conexión a MySQL que crea
// la variable $conexion usada en las consultas COUNT(*).
require_once "../configuration/conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - GOLDEN FIT</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,Helvetica,sans-serif; }
        body { display:flex; background:#f4f4f4; }
 
        /*
           SIDEBAR / MENÚ LATERAL
           FUNCIÓN: Menú fijo de 250px de ancho que siempre
           permanece visible aunque el usuario haga scroll.
           display:flex + flex-direction:column permite empujar
           el botón de cerrar sesión hasta la parte inferior.
        */
        .sidebar {
            width: 250px; height: 100vh; background: #1e293b;
            padding-top: 20px; position: fixed;
            display: flex; flex-direction: column;
        }
        .sidebar h2 { color: white; text-align: center; margin-bottom: 30px; }
 
        /* flex:1 hace que nav ocupe todo el espacio disponible,
           empujando el sidebar-footer (botón cerrar sesión) al fondo */
        .sidebar nav { flex: 1; }
        .sidebar ul  { list-style: none; }
        .sidebar ul li { margin: 10px 0; }
        .sidebar ul li a {
            display: block; color: white; text-decoration: none;
            padding: 15px 20px; transition: 0.3s;
        }
        /* Efecto hover: fondo más claro y texto desplazado */
        .sidebar ul li a:hover { background: #334155; padding-left: 30px; }
 
        /* Sección inferior del sidebar separada con línea divisora */
        .sidebar-footer { padding: 20px; border-top: 1px solid #334155; }
 
        /*
           BOTÓN CERRAR SESIÓN
           FUNCIÓN: Se muestra en rojo cuando el usuario YA
           inició sesión ($_SESSION['logueado'] = true).
           Al presionarlo va a LoginController.php?accion=logout
           que destruye la sesión y redirige al login.
        */
        .btn-cerrar-sesion {
            display: block; width: 100%; padding: 12px;
            background: #ef4444; /* Rojo indica acción de salida */
            color: white; border: none; border-radius: 8px;
            font-size: 14px; text-align: center;
            text-decoration: none; cursor: pointer; transition: 0.3s;
        }
        .btn-cerrar-sesion:hover { background: #dc2626; }
 
        /* Botón gris de iniciar sesión cuando NO hay sesión activa */
        .btn-sesion {
            display: block; width: 100%; padding: 12px;
            background: transparent; color: #94a3b8;
            border: 1px solid #334155; border-radius: 8px;
            font-size: 14px; text-align: center;
            text-decoration: none; transition: 0.3s;
        }
        .btn-sesion:hover { background: #334155; color: white; }
 
        /*
           CONTENIDO PRINCIPAL
           FUNCIÓN: Área de trabajo desplazada 250px a la derecha
           para no quedar oculta detrás del sidebar fijo.
        */
        .contenido { margin-left: 250px; padding: 40px; width: 100%; }
        .contenido h1 { color: #1e293b; font-size: 28px; margin-bottom: 8px; }
        .contenido > p { color: #64748b; font-size: 15px; line-height: 1.7; max-width: 600px; margin-bottom: 36px; }
 
        /* Mensaje verde con el nombre y rol del empleado logueado */
        .bienvenida-sesion {
            display: inline-block; background: #f0fdf4;
            border: 1px solid #bbf7d0; color: #16a34a;
            border-radius: 8px; padding: 10px 16px;
            font-size: 13px; margin-bottom: 30px;
        }
 
        /*
           CARDS DE RESUMEN
           FUNCIÓN: Tarjetas que muestran conteos en tiempo real
           consultando la BD con PHP usando COUNT(*) por tabla.
           CSS Grid las distribuye automáticamente según el ancho.
        */
        .cards-resumen {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 20px; max-width: 780px; margin-bottom: 40px;
        }
        .card-res {
            background: white; border-radius: 12px; padding: 24px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.07);
            border-left: 4px solid #1e293b;
        }
        .card-res .icono { font-size: 28px; margin-bottom: 10px; }
        .card-res h3 { color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
        .card-res p  { color: #1e293b; font-size: 32px; font-weight: bold; }
 
        /*
           IMAGEN DECORATIVA DE LA TIENDA
           FUNCIÓN: Foto grande debajo de las cards.
           object-fit:cover recorta sin deformar la imagen.
        */
        .TIENDA {
            display: block;
            margin: 30px auto 0 auto;
            width: 100%;
            max-width: 750px;
            height: 420px;
            object-fit: cover;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        }
    </style>
</head>
<body>
 
<!--
     SIDEBAR / MENÚ LATERAL
     FUNCIÓN: Navegación principal del sistema.
     El bloque PHP del footer verifica $_SESSION['logueado']:
     - Si hay sesión activa botón rojo "Cerrar Sesión"
     - Si no hay sesión  botón gris "Iniciar Sesión"
-->
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
 
    <!-- Footer del sidebar: cambia según si hay sesión activa o no -->
    <div class="sidebar-footer">
        <?php if (!empty($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
            <!-- HAY SESIÓN  botón rojo de cerrar sesión
                 Redirige a LoginController con accion=logout
                 que ejecuta session_unset() + session_destroy() -->
            <a href="../controllers/LoginController.php?accion=logout" class="btn-cerrar-sesion">
                Cerrar Sesión
            </a>
        <?php else: ?>
            <!-- SIN SESIÓN botón gris de iniciar sesión -->
            <a href="../views/index.php" class="btn-sesion">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</div>
 
<!--
     CONTENIDO PRINCIPAL
     FUNCIÓN: Panel de bienvenida con el nombre del empleado
     logueado y tarjetas con conteos en tiempo real de la BD.
-->
<div class="contenido">
    <h1>Bienvenido a GOLDEN FIT</h1>
 
    <!-- Mensaje de bienvenida: solo aparece si hay sesión activa -->
    <?php if (!empty($_SESSION['empleado_nombre'])): ?>
        <div class="bienvenida-sesion">
            Se inicio como:
            <strong><?php echo htmlspecialchars($_SESSION['empleado_nombre']); ?></strong>
            — Rol: <strong><?php echo htmlspecialchars($_SESSION['empleado_rol']); ?></strong>
        </div>
    <?php endif; ?>
 
    <p>Tienda online de ropa de todas las categorías para damas y caballeros,
       con la mejor calidad y a los mejores precios.</p>
 
    <!--
         CARDS DE RESUMEN
         FUNCIÓN: Cada card ejecuta un COUNT(*) en su tabla
         para mostrar el total de registros en tiempo real.
     -->
    <div class="cards-resumen">
 
        <!-- Card Clientes: cuenta todos los registros de la tabla cliente -->
        <div class="card-res">
            <div class="icono"></div>
            <h3>Clientes</h3>
            <p><?php
                $r = mysqli_query($conexion, "SELECT COUNT(*) AS t FROM cliente");
                echo mysqli_fetch_assoc($r)['t'];
            ?></p>
        </div>
 
        <!-- Card Productos: cuenta todos los registros de la tabla producto -->
        <div class="card-res">
            <div class="icono"></div>
            <h3>Productos</h3>
            <p><?php
                $r = mysqli_query($conexion, "SELECT COUNT(*) AS t FROM producto");
                echo mysqli_fetch_assoc($r)['t'];
            ?></p>
        </div>
 
        <!-- Card Ventas: cuenta todos los registros de la tabla venta -->
        <div class="card-res">
            <div class="icono"></div>
            <h3>Ventas</h3>
            <p><?php
                $r = mysqli_query($conexion, "SELECT COUNT(*) AS t FROM venta");
                echo mysqli_fetch_assoc($r)['t'];
            ?></p>
        </div>
 
        <!-- Card Empleados: cuenta todos los registros de la tabla empleado -->
        <div class="card-res">
            <div class="icono"></div>
            <h3>Empleados</h3>
            <p><?php
                $r = mysqli_query($conexion, "SELECT COUNT(*) AS t FROM empleado");
                echo mysqli_fetch_assoc($r)['t'];
            ?></p>
        </div>
 
    </div>
 
    <!-- 
         IMAGEN DECORATIVA DE LA TIENDA
         FUNCIÓN: Imagen grande debajo de las cards.
    -->
    <img class="TIENDA"
         src="https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?w=1200"
         alt="Tienda Golden Fit">
         <!-- igual que antes si combio esta url por otra la imagen cambia -->
 
</div>
 
</body>