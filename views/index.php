<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Golden Fit</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; }

        /*
           FONDO DEL LOGIN CON IMAGEN
           FUNCIÓN: Cubre toda la pantalla con una imagen de fondo. */
        body {
            background-image: url("https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=1600");
            /* puedo cambiar la imagen de fondo cambiando la url*/
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Capa oscura semitransparente sobre la imagen de fondo
           para que la tarjeta de login se lea mejor */
        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.50); /* Oscuridad: 0.0 = transparente, 1.0 = negro total */
            z-index: 0;
        }

        /* La tarjeta queda encima de la capa oscura */
        .login-card {
            position: relative;
            z-index: 1;
            background: white;
            border-radius: 12px;
            width: 380px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.4);
        }

        /* Encabezado oscuro con el nombre del sistema */
        .login-header {
            background: #1e293b;
            padding: 30px;
            text-align: center;
        }
        .login-header h2 { color: white; font-size: 24px; letter-spacing: 1px; }
        .login-header p  { color: rgba(255,255,255,0.6); font-size: 13px; margin-top: 6px; }

        /* Cuerpo del formulario */
        .login-body { padding: 30px; }

        /* Cada campo del formulario: label + input */
        .campo { margin-bottom: 18px; }
        .campo label { display: block; font-size: 13px; font-weight: bold; color: #1e293b; margin-bottom: 6px; }
        .campo input {
            width: 100%; padding: 11px 14px;
            border: 1px solid #cbd5e1; border-radius: 8px;
            font-size: 14px; transition: border 0.2s;
        }
        /* Borde azul cuando el input está enfocado */
        .campo input:focus { outline: none; border-color: #1e293b; }

        /* Botón principal de ingresar */
        .btn-login {
            width: 100%; padding: 13px; background: #1e293b;
            color: white; border: none; border-radius: 8px;
            font-size: 15px; font-weight: bold; cursor: pointer;
            transition: 0.3s; margin-top: 6px;
        }
        .btn-login:hover { background: #334155; transform: translateY(-2px); box-shadow: 0 5px 12px rgba(0,0,0,0.2); }

        /* Caja roja de error: solo aparece si las credenciales son incorrectas */
        .error {
            background: #fee2e2; color: #dc2626;
            border: 1px solid #fca5a5; border-radius: 8px;
            padding: 10px 14px; font-size: 13px;
            margin-bottom: 18px; text-align: center;
        }
    </style>
</head>
<body>

    <!-- Tarjeta principal del login centrada sobre la imagen de fondo -->
    <div class="login-card">

        <!-- Encabezado oscuro con el nombre del sistema -->
        <div class="login-header">
            <h2>GOLDEN FIT</h2>
            <p>Ingresa tus credenciales para continuar</p>
        </div>

        <div class="login-body">

            <!--
                 MENSAJE DE ERROR
                 FUNCIÓN: Solo se muestra si $error_login tiene contenido.
                 La variable viene del LoginController.php cuando las
                 credenciales no coinciden con ningún empleado en la BD.
            -->
            <?php if (!empty($error_login)): ?>
                <div class="error"><?php echo htmlspecialchars($error_login); ?></div>
            <?php endif; ?>

            <!--
                 FORMULARIO DE LOGIN
                 FUNCIÓN: Envía usuario y clave por POST al controller.
                 El controller verifica en la BD y redirige al inicio
                 si son correctos, o vuelve aquí con mensaje de error.
            -->
            <form method="POST" action="../controllers/LoginController.php">

                <div class="campo">
                    <label>Usuario</label>
                    <!-- autofocus: el cursor se coloca aquí automáticamente al abrir la página -->
                    <input type="text" name="usuario" placeholder="Ingresa tu usuario" required autofocus>
                </div>

                <div class="campo">
                    <label>Contraseña</label>
                    <!-- type="password": oculta los caracteres escritos -->
                    <input type="password" name="clave" placeholder="Ingresa tu contraseña" required>
                </div>

                <!-- Botón que envía el formulario al LoginController.php -->
                <button type="submit" class="btn-login">INGRESAR</button>
            </form>
        </div>
    </div>
</body>
</html>
