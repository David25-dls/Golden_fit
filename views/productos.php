<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Golden Fit</title>
    <!-- jsPDF: librería para generar PDFs directamente en el navegador sin necesitar servidor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- AutoTable: plugin de jsPDF que permite crear tablas formateadas en el PDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,Helvetica,sans-serif; }
        body { display:flex; background:#f4f4f4; }

        /* Sidebar compartido en todas las vistas */
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

        .contenido { margin-left:250px; padding:35px; width:100%; }

        /*
           HEADER DE SECCIÓN
           FUNCIÓN: Fila con el título y los botones principales
           alineados a los extremos usando justify-content:space-between.
        */
        .seccion-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:30px; flex-wrap:wrap; gap:12px; }
        .seccion-header h1 { color:#1e293b; font-size:24px; }
        .acciones-top { display:flex; gap:12px; }

        /* Botón oscuro para agregar producto */
        .btn-agregar { padding:11px 24px; background:linear-gradient(135deg,#334155,#1c2c42); color:white; border:none; border-radius:10px; font-size:14px; font-weight:bold; cursor:pointer; transition:0.3s; }
        .btn-agregar:hover { transform:translateY(-2px); box-shadow:0 5px 12px rgba(0,0,0,0.2); }
        /* Botón verde para generar reporte PDF */
        .btn-reporte { padding:11px 24px; background:linear-gradient(135deg,#16a34a,#15803d); color:white; border:none; border-radius:10px; font-size:14px; font-weight:bold; cursor:pointer; transition:0.3s; }
        .btn-reporte:hover { transform:translateY(-2px); box-shadow:0 5px 12px rgba(21,128,61,0.35); }

        /*
           GRID DE CARDS
           FUNCIÓN: Distribuye los productos en tarjetas con CSS Grid.
           auto-fill crea tantas columnas como quepan.
           minmax(230px,1fr) cada columna mínimo 230px de ancho.
        */
        .productos-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(230px, 1fr)); gap:22px; }

        /* Tarjeta individual del producto */
        .producto-card { background:white; border-radius:14px; box-shadow:0 4px 18px rgba(0,0,0,0.08); overflow:hidden; display:flex; flex-direction:column; transition:transform 0.25s, box-shadow 0.25s; }
        /* Efecto hover: se eleva y la sombra se intensifica */
        .producto-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px rgba(0,0,0,0.14); }

        /* Imagen real del producto cargada desde URL */
        .card-img { width:100%; height:180px; object-fit:cover; display:block; }
        /* Banner de emoji que reemplaza la imagen cuando no hay URL */
        .card-banner { width:100%; height:180px; display:flex; justify-content:center; align-items:center; font-size:56px; }

        /* Cuerpo de la card con todos los datos */
        .card-body { padding:16px; flex:1; display:flex; flex-direction:column; gap:5px; }
        .card-categoria { font-size:10px; text-transform:uppercase; letter-spacing:1.2px; color:#64748b; font-weight:bold; }
        .card-marca     { font-size:11px; color:#94a3b8; }
        .card-nombre    { font-size:15px; font-weight:bold; color:#1e293b; }
        .card-atributos { display:flex; gap:6px; flex-wrap:wrap; margin-top:4px; }
        .badge { background:#f1f5f9; color:#475569; font-size:11px; padding:3px 9px; border-radius:20px; }
        .card-footer { display:flex; justify-content:space-between; align-items:center; margin-top:12px; padding-top:10px; border-top:1px solid #f1f5f9; }
        .card-precio { font-size:20px; font-weight:bold; color:#1e293b; }
        .card-stock  { font-size:12px; background:#f1f5f9; color:#475569; padding:4px 10px; border-radius:20px; }
        .card-acciones { display:flex; gap:8px; margin-top:12px; }
        .btn-editar-card   { flex:1; padding:8px; background:#3b82f6; color:white; border:none; border-radius:8px; cursor:pointer; font-size:13px; transition:0.2s; }
        .btn-editar-card:hover { background:#2563eb; }
        .btn-eliminar-card { flex:1; padding:8px; background:#ef4444; color:white; border:none; border-radius:8px; cursor:pointer; font-size:13px; transition:0.2s; }
        .btn-eliminar-card:hover { background:#dc2626; }

        .sin-productos { text-align:center; padding:60px 20px; color:#94a3b8; grid-column:1/-1; }
        .sin-productos span { font-size:48px; display:block; margin-bottom:16px; }

        /* Estilos del modal */
        .modal-fondo { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:999; justify-content:center; align-items:center; }
        .modal-fondo.activo { display:flex; }
        .modal { background:white; border-radius:14px; padding:30px; width:430px; box-shadow:0 10px 40px rgba(0,0,0,0.3); max-height:90vh; overflow-y:auto; }
        .modal h2 { color:#1e293b; margin-bottom:20px; text-align:center; }
        .modal input, .modal select { width:100%; padding:10px 14px; margin-bottom:13px; border:1px solid #cbd5e1; border-radius:8px; font-size:14px; }
        .modal-botones { display:flex; gap:10px; justify-content:center; margin-top:6px; }
        .btn-guardar { padding:10px 30px; background:#1e293b; color:white; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
        .btn-cancelar{ padding:10px 30px; background:#e2e8f0; color:#1e293b; border:none; border-radius:8px; cursor:pointer; font-size:14px; }
    </style>
</head>
<body>

<?php 
//session_start(); ?>

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
            <a href="../controllers/LoginController.php?accion=logout" class="btn-cerrar-sesion">Cerrar Sesión</a>
        <?php else: ?>
            <a href="../views/index.php" class="btn-sesion">Iniciar Sesión</a>
        <?php endif; ?>
    </div>
</div>

<div class="contenido">
    <div class="seccion-header">
        <h1>NUESTROS PRODUCTOS</h1>
        <div class="acciones-top">
            <!-- Llama a generarPDF() de JavaScript para descargar el reporte -->
            <button class="btn-reporte" onclick="generarPDF()">Generar Reporte PDF</button>
            <!-- Abre el modal de agregar producto -->
            <button class="btn-agregar" onclick="abrirModal()">Agregar Producto</button>
        </div>
    </div>

    <!--
         GRID DE CARDS DE PRODUCTOS
         FUNCIÓN: Recorre $productos resultado con JOIN de categoría
         del controller. Por cada producto genera una card con:
         - Imagen URL si existe, emoji de fallback si falla o está vacía
         - Nombre, marca, categoría, talla, color, precio, stock
         - Botones de editar y eliminar
         También llena $datos_pdf para el reporte JavaScript.
    -->
    <div class="productos-grid">
    <?php
        // Colores de fondo por categoría para el banner de emoji
        $bannerColor = [
            'Polos'=>'#dbeafe','Pantalones'=>'#fef3c7','Zapatillas'=>'#dcfce7',
            'Casacas'=>'#fee2e2','Shorts'=>'#ede9fe','Vestidos'=>'#fce7f3',
            'Camisas'=>'#e0f2fe','Buzos'=>'#ffedd5','Accesorios'=>'#f0fdf4',
            'Ropa Interior'=>'#fdf4ff',
        ];
        // Emojis representativos por categoría
        $emojiCat = [
            'Polos'=>'👕','Pantalones'=>'👖','Zapatillas'=>'👟','Casacas'=>'🧥',
            'Shorts'=>'🩳','Vestidos'=>'👗','Camisas'=>'👔','Buzos'=>'🏃',
            'Accesorios'=>'👜','Ropa Interior'=>'🩲',
        ];

        // Array PHP que se convertirá a JSON para el reporte PDF
        $datos_pdf = [];

        if (!$productos || mysqli_num_rows($productos) === 0):
    ?>
        <div class="sin-productos"><span></span><p>No hay productos registrados.</p></div>
    <?php
        else:
            while ($p = mysqli_fetch_assoc($productos)):
                $cat   = $p['Nombre_categoria'] ?? 'General';
                $color = $bannerColor[$cat]  ?? '#f1f5f9';
                $emoji = $emojiCat[$cat]     ?? '🧥';

                // Guardamos los datos para el JSON del reporte PDF
                $datos_pdf[] = [
                    'id'=>$p['ID_producto'], 'nombre'=>$p['Nombre_producto'],
                    'talla'=>$p['Talla'], 'color'=>$p['Color'], 'marca'=>$p['Marca'],
                    'precio'=>$p['Precio'], 'stock'=>$p['Stock'], 'categoria'=>$cat,
                ];
                $imgUrl = !empty($p['imagen']) ? htmlspecialchars($p['imagen']) : '';
    ?>
        <div class="producto-card">
            <?php if ($imgUrl): ?>
                <!-- Imagen real desde URL ingresada por el usuario -->
                <!-- onerror: si la URL falla, oculta la img y muestra el emoji fallback -->
                <img class="card-img"
                     src="<?php echo $imgUrl; ?>"
                     alt="<?php echo htmlspecialchars($p['Nombre_producto']); ?>"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <!-- Fallback oculto que aparece si la imagen URL falla -->
                <div class="card-banner" style="background:<?php echo $color;?>;display:none;"><?php echo $emoji;?></div>
            <?php else: ?>
                <!-- Sin URL: muestra directamente el emoji con color de su categoría -->
                <div class="card-banner" style="background:<?php echo $color;?>"><?php echo $emoji;?></div>
            <?php endif; ?>

            <div class="card-body">
                <span class="card-categoria"><?php echo htmlspecialchars($cat); ?></span>
                <span class="card-marca"><?php echo htmlspecialchars($p['Marca']); ?></span>
                <div class="card-nombre"><?php echo htmlspecialchars($p['Nombre_producto']); ?></div>
                <div class="card-atributos">
                    <span class="badge">Talla: <?php echo htmlspecialchars($p['Talla']); ?></span>
                    <span class="badge">Color: <?php echo htmlspecialchars($p['Color']); ?></span>
                </div>
                <div class="card-footer">
                    <span class="card-precio">S/ <?php echo number_format($p['Precio'],2); ?></span>
                    <span class="card-stock">Stock: <?php echo $p['Stock']; ?></span>
                </div>
                <div class="card-acciones">
                    <!-- Pasa todos los datos del producto a la función JS de editar -->
                    <button class="btn-editar-card" onclick="abrirEditar(
                        '<?php echo $p['ID_producto']; ?>',
                        '<?php echo addslashes($p['Nombre_producto']); ?>',
                        '<?php echo addslashes($p['Talla']); ?>',
                        '<?php echo addslashes($p['Color']); ?>',
                        '<?php echo addslashes($p['Marca']); ?>',
                        '<?php echo $p['Precio']; ?>',
                        '<?php echo $p['Stock']; ?>',
                        '<?php echo $p['CATEGORIA_ID_categoria']; ?>',
                        '<?php echo addslashes($p['imagen'] ?? ''); ?>'
                    )">Editar</button>
                    <button class="btn-eliminar-card" onclick="eliminar('<?php echo $p['ID_producto']; ?>')">Eliminar</button>
                </div>
            </div>
        </div>
    <?php endwhile; endif; ?>
    </div>
</div>

<!-- Modal Agregar Producto -->
<div class="modal-fondo" id="modalAgregar">
    <div class="modal">
        <h2>AGREGAR PRODUCTO</h2>
        <form method="POST" action="../controllers/productoController.php">
            <input type="text"   name="nombre"  placeholder="Nombre del producto" required>
            <input type="text"   name="talla"   placeholder="Talla (ej: M, L, 42)">
            <input type="text"   name="color"   placeholder="Color">
            <input type="text"   name="marca"   placeholder="Marca">
            <input type="number" name="precio"  placeholder="Precio (S/)" step="0.01" min="0" required>
            <input type="number" name="stock"   placeholder="Stock disponible" min="0" required>
            <!-- Campo URL: oninput llama a la preview en tiempo real mientras se escribe -->
            <input type="url" name="imagen" id="add-imagen" placeholder="URL de imagen (opcional)" oninput="previsualizarAgregar(this.value)">
            <!-- Vista previa: aparece/desaparece según si la URL es válida -->
            <div id="add-preview" style="display:none;margin-bottom:13px;text-align:center;">
                <img id="add-preview-img" src="" alt="Vista previa" style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;border:1px solid #e2e8f0;">
            </div>
            <!-- Select de categorías cargado dinámicamente desde la tabla 'categoria' de la BD -->
            <select name="id_categoria" required>
                <option value="">Selecciona categoría </option>
                <?php
                mysqli_data_seek($categorias, 0); // Rebobina el cursor al inicio del resultado
                while ($cat = mysqli_fetch_assoc($categorias)):
                ?>
                <option value="<?php echo $cat['ID_categoria']; ?>">
                    <?php echo htmlspecialchars($cat['Nombre_categoria']); ?>
                </option>
                <?php endwhile; ?>
            </select>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">GUARDAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarModal()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Producto -->
<div class="modal-fondo" id="modalEditar">
    <div class="modal">
        <h2>EDITAR PRODUCTO</h2>
        <form method="POST" action="../controllers/productoController.php">
            <input type="hidden" name="accion"    value="editar">
            <input type="hidden" name="id"        id="edit-id">
            <input type="text"   name="nombre"    id="edit-nombre"    placeholder="Nombre" required>
            <input type="text"   name="talla"     id="edit-talla"     placeholder="Talla">
            <input type="text"   name="color"     id="edit-color"     placeholder="Color">
            <input type="text"   name="marca"     id="edit-marca"     placeholder="Marca">
            <input type="number" name="precio"    id="edit-precio"    placeholder="Precio (S/)" step="0.01" min="0" required>
            <input type="number" name="stock"     id="edit-stock"     placeholder="Stock" min="0" required>
            <input type="url"    name="imagen"    id="edit-imagen"    placeholder="URL de imagen (opcional)" oninput="previsualizarEditar(this.value)">
            <div id="edit-preview" style="display:none;margin-bottom:13px;text-align:center;">
                <img id="edit-preview-img" src="" alt="Vista previa" style="max-height:120px;max-width:100%;border-radius:8px;object-fit:cover;border:1px solid #e2e8f0;">
            </div>
            <select name="id_categoria" id="edit-categoria" required>
                <option value="">Selecciona categoría </option>
                <?php
                mysqli_data_seek($categorias, 0);
                while ($cat = mysqli_fetch_assoc($categorias)):
                ?>
                <option value="<?php echo $cat['ID_categoria']; ?>">
                    <?php echo htmlspecialchars($cat['Nombre_categoria']); ?>
                </option>
                <?php endwhile; ?>
            </select>
            <div class="modal-botones">
                <button type="submit" class="btn-guardar">ACTUALIZAR</button>
                <button type="button" class="btn-cancelar" onclick="cerrarEditar()">CANCELAR</button>
            </div>
        </form>
    </div>
</div>

<!--
     JSON OCULTO PARA EL PDF
     FUNCIÓN: json_encode() convierte el array PHP $datos_pdf
     a formato JSON. JavaScript lo leerá para generar el reporte
     sin necesitar otra petición al servidor.
-->
<script id="json-productos" type="application/json">
    <?php echo json_encode($datos_pdf); ?>
</script>

<script>
    /* 
    MODALES 
    */
    function abrirModal()  { document.getElementById('modalAgregar').classList.add('activo'); }
    function cerrarModal() { document.getElementById('modalAgregar').classList.remove('activo'); }

    // Abre el modal de editar y carga los datos actuales del producto
    function abrirEditar(id, nombre, talla, color, marca, precio, stock, idCat, imagen) {
        document.getElementById('edit-id').value        = id;
        document.getElementById('edit-nombre').value    = nombre;
        document.getElementById('edit-talla').value     = talla;
        document.getElementById('edit-color').value     = color;
        document.getElementById('edit-marca').value     = marca;
        document.getElementById('edit-precio').value    = precio;
        document.getElementById('edit-stock').value     = stock;
        document.getElementById('edit-categoria').value = idCat;
        document.getElementById('edit-imagen').value    = imagen;
        previsualizarEditar(imagen); // Muestra la imagen actual en el modal
        document.getElementById('modalEditar').classList.add('activo');
    }
    function cerrarEditar() { document.getElementById('modalEditar').classList.remove('activo'); }

    function eliminar(id) {
        if (confirm('¿Eliminar este producto?')) {
            window.location.href = '../controllers/productoController.php?accion=eliminar&id=' + id;
        }
    }

    // Cierra los modales al hacer clic en el fondo oscuro
    document.getElementById('modalAgregar').addEventListener('click', e => { if(e.target===e.currentTarget) cerrarModal(); });
    document.getElementById('modalEditar').addEventListener('click',  e => { if(e.target===e.currentTarget) cerrarEditar(); });

    /* PREVIEW DE IMAGEN EN TIEMPO REAL 
    FUNCIÓN: Mientras el usuario escribe/pega la URL en el campo,
    muestra una vista previa instantánea dentro del modal.
       Si la URL es inválida, onerror oculta la preview automáticamente. */
    function previsualizarAgregar(url) {
        const preview = document.getElementById('add-preview');
        const img     = document.getElementById('add-preview-img');
        if (url.trim() !== '') {
            img.src = url;
            preview.style.display = 'block';
            img.onerror = () => { preview.style.display = 'none'; };
        } else { preview.style.display = 'none'; }
    }
    function previsualizarEditar(url) {
        const preview = document.getElementById('edit-preview');
        const img     = document.getElementById('edit-preview-img');
        if (url && url.trim() !== '') {
            img.src = url;
            preview.style.display = 'block';
            img.onerror = () => { preview.style.display = 'none'; };
        } else { preview.style.display = 'none'; }
    }

    /* GENERAR REPORTE PDF 
       FUNCIÓN: Lee los datos del JSON oculto generado por PHP
       y crea un PDF con encabezado, resumen de inventario y tabla.
       Se descarga automáticamente sin necesitar el servidor. */
    function generarPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Encabezado del PDF con los colores tematicos de mi tienda
        doc.setFillColor(30, 41, 59);
        doc.rect(0, 0, 210, 36, 'F');
        doc.setTextColor(255,255,255);
        doc.setFontSize(20); doc.setFont('helvetica','bold');
        doc.text('GOLDEN FIT', 105, 15, { align:'center' });
        doc.setFontSize(11); doc.setFont('helvetica','normal');
        doc.text('Reporte de Productos', 105, 24, { align:'center' });
        doc.setFontSize(9); doc.setTextColor(180,180,180);
        const fecha = new Date().toLocaleDateString('es-PE', { year:'numeric', month:'long', day:'numeric' });
        doc.text('Generado el: ' + fecha, 105, 31, { align:'center' });

        // Leemos los datos del JSON generado por PHP
        const productos = JSON.parse(document.getElementById('json-productos').textContent);

        // Calculamos el resumen del inventario
        const totalProd  = productos.length;
        const totalStock = productos.reduce((a,p) => a + parseInt(p.stock||0), 0);
        const valorInv   = productos.reduce((a,p) => a + parseFloat(p.precio||0)*parseInt(p.stock||0), 0);

        doc.setTextColor(30,41,59); doc.setFontSize(10); doc.setFont('helvetica','bold');
        doc.text('Resumen del inventario', 14, 45);
        doc.setFont('helvetica','normal'); doc.setFontSize(9);
        doc.text(`Productos: ${totalProd}`, 14, 52);
        doc.text(`Stock total: ${totalStock}`, 80, 52);
        doc.text(`Valor total: S/ ${valorInv.toFixed(2)}`, 148, 52);

        // Tabla de productos con AutoTable
        doc.autoTable({
            startY: 57,
            head: [['ID','Nombre','Categoría','Talla','Color','Marca','Precio','Stock']],
            body: productos.map(p => [p.id, p.nombre, p.categoria, p.talla, p.color, p.marca, 'S/ '+parseFloat(p.precio).toFixed(2), p.stock]),
            headStyles: { fillColor:[30,41,59], textColor:255, fontStyle:'bold', fontSize:9 },
            alternateRowStyles: { fillColor:[248,250,252] },
            styles: { fontSize:8.5, cellPadding:4 },
        });

        // Número de página al pie de cada hoja
        const total = doc.internal.getNumberOfPages();
        for (let i=1; i<=total; i++) {
            doc.setPage(i); doc.setFontSize(8); doc.setTextColor(160);
            doc.text(`Página ${i} de ${total}  |  Golden Fit © ${new Date().getFullYear()}`, 105, doc.internal.pageSize.height-8, {align:'center'});
        }

        // Descarga automática del PDF en el navegador
        doc.save('reporte_productos_golden_fit.pdf');
    }
</script>
</body>
</html>
