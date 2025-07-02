  <?php
          if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir_material'])) {
            $dir = __DIR__ . "/pendientes/";
            if (!is_dir($dir)) mkdir($dir);

            $nombre = trim($_POST['nombre']);
            $registro = trim($_POST['registro']);
            $materia = trim($_POST['materia']);
            $titulo = trim($_POST['titulo']);
            $instruccion = trim($_POST['instruccion']);

            $baseName = time();
            $metaFile = $dir . $baseName . ".txt";

            $contenidoMeta = $materia . "\n" .
                 $titulo . "\n" .
                 $nombre . "\n" .
                 $registro . "\n" .
                 $instruccion;

file_put_contents($metaFile, $contenidoMeta);


            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
              $tmp = $_FILES['archivo']['tmp_name'];
              $original = basename($_FILES['archivo']['name']);
              $archivoDestino = $dir . $baseName . "-" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $original);
              if (move_uploaded_file($tmp, $archivoDestino)) {
                echo "<p style='color:green'>Archivo y datos enviados correctamente.</p>";
              } else {
                echo "<p>Error al guardar el archivo.</p>";
              }
            } else {
              echo "<p style='color:green'>Datos enviados correctamente (sin archivo).</p>";
            }
          }
          ?>
          
  <!DOCTYPE html>
  <html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malla Curricular</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* 👇 FOOTER 👇 */
 footer {
  background-color: rgb(2, 54, 109);
  color: white;
  width: 100vw;
  padding: 2rem 2rem;
  font-family: 'Segoe UI', sans-serif;
  line-height: 1.2;
}
.footer-contenido {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: flex-start;
  max-width: 1200px;
  margin: 0 auto;
  width: 100%;
}
.footer-col {
  flex: 1 1 250px;
  margin-bottom: 1.5rem;
}
.footer-col h3, .footer-col h4 {
  margin-bottom: 0.8rem;
  font-size: 1.1rem;
}
.footer-col p, .footer-col a {
  font-size: 0.85rem;
  color: white;
  text-decoration: none;
  margin: 0.3rem 3rem 0.3rem 0;
   text-align: justify; /* ✅ Justifica el texto */
 
}
.footer-col a:hover {
  text-decoration: underline;
}
.footer-bottom {
  border-top: 1px solid rgb(237, 237, 237);
  margin-top: 1.5rem;
  padding-top: 1rem;
  text-align: center;
  font-size: 0.75rem;
  color: white; /* Asegura color en contenedor */
}
.footer-bottom p {
  color: white; /* ✅ Fuerza el blanco en los <p> */
  margin: 0.2rem 0;
}
    </style>
  </head>
  <body>
      <!-- Fondo animado con canvas -->
    <canvas id="node-background"></canvas>
      <button class="toggle-btn" onclick="toggleSidebar()">☰</button>

  <aside class="sidebar collapsed" id="sidebar">
      <nav class="menu">
        <a href="index.html"><i class="fas fa-home"></i><span class="text">Inicio</span></a>
        <a href="malla.php" class="active"><i class="fas fa-table-list"></i><span class="text">Malla</span></a>
        <a href="area.html"><i class="fas fa-layer-group"></i><span class="text">Áreas</span></a>
        <a href="perfil.html"><i class="fas fa-user-graduate"></i><span class="text">Perfil</span></a>
        <a href="modalidad.html"><i class="fas fa-sign-in-alt"></i><span class="text">Modalidad</span></a>
        <a href="beneficios.html"><i class="fas fa-coins"></i><span class="text">Beneficios</span></a>
        <a href="material.php"><i class="fas fa-envelope"></i><span class="text">Contacto</span></a>
      </nav>
    </aside>

  <main>
  <div class="mat-wrapper">
    <div class="mat-container">
    <h1>📘 Material de Apoyo</h1>

    <div class="mat-tabs">
      <button class="mat-tab-btn" onclick="showMatTab('temas')">Temas Especiales</button>
          <button class="mat-tab-btn" onclick="showMatTab('sitios')">Sitios Web</button>
      <button class="mat-tab-btn" onclick="showMatTab('ofimatica')">Teleinformática</button>
      <button class="mat-tab-btn" onclick="showMatTab('sitios')">Programación</button>
      <button class="mat-tab-btn" onclick="showMatTab('sistemas')">Sistemas Operativos</button>
    </div>

<?php
$materias = [
  "temas" => "Temas Especiales",
  "sitios" => "Sitios Web",
  "ofimatica" => "Teleinformática",
  "programacion" => "Programación",
  "sistemas" => "Sistemas Operativos"
];

foreach ($materias as $clave => $nombreMateria):
  $archivo = $clave . ".txt";
?>
<div id="<?php echo $clave; ?>" class="mat-tab-content">
  <h3>📘 Recursos de <?php echo $nombreMateria; ?></h3>
  <ul>
    <?php
    if (file_exists($archivo)) {
      $lineas = file($archivo);
      foreach ($lineas as $index => $linea) {
        $partes = explode("|", trim($linea));
        $materia = $partes[0] ?? '';
        $titulo = $partes[1] ?? '';
        $contenido = str_replace("\\n", "\n", $partes[2] ?? '');
$archivoAdjunto = $partes[3] ?? '';

$contenidoHtml = nl2br($contenido); // conserva saltos de línea como <br>
$archivoHtml = "";

if ($archivoAdjunto) {
  $ruta = "pendientes/archivos/" . $archivoAdjunto;
  $ext = strtolower(pathinfo($archivoAdjunto, PATHINFO_EXTENSION));
  if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
    $archivoHtml = "<br><img src='" . htmlspecialchars($ruta) . "' style='max-width:100%; margin-top:10px; border-radius:6px;'><br>";
  } else {
    $archivoHtml = "<p style='margin-top:10px;'><a href='" . htmlspecialchars($ruta) . "' target='_blank' style='color:#007BFF;'>📎 Ver archivo adjunto</a></p>";
  }
}

echo "<li>
  <button type='button' class='abrir-popup' 
    data-titulo=\"" . htmlspecialchars($titulo) . "\" 
    data-contenido=\"" . $archivoHtml . "<div style='color:#000000; margin-top:10px;'>" . $contenidoHtml . "</div>\"
    style='color:#000;'>
    📄 " . htmlspecialchars($titulo) . "
  </button>
</li>";

      }
    } else {
      echo "<li style='color:gray;'>No hay materiales aún.</li>";
    }
    ?>
  </ul>
</div>
<?php endforeach; ?>

<form class="mat-upload" action="upload_material.php" method="POST" enctype="multipart/form-data" style="max-width:500px; margin:auto; background:#f9f9f9; padding:20px; border-radius:10px;">
            <h3 style="margin-bottom:10px;">📤 Subir Material de Apoyo</h3>

            <label>Nombre completo:</label>
            <input type="text" name="nombre" required placeholder="Ej: Juan Pérez" style="width:100%; margin-bottom:10px; padding:8px;">

            <label>Nro de registro:</label>
            <input type="text" name="registro" required placeholder="Ej: 20231234" style="width:100%; margin-bottom:10px; padding:8px;">

           <label>Materia:</label>
            <input list="materias" name="materia" required placeholder="Ej: Álgebra" style="width:100%; margin-bottom:10px; padding:8px;">
            <datalist id="materias">
            <option value="Sitios">
            <option value="Programación">
            <option value="Teleinformática">
            <option value="Sistemas">
            <option value="Temas">
            </datalist>

            <label>Título:</label>
            <input type="text" name="titulo" required placeholder="Ej: Guía 1" style="width:100%; margin-bottom:10px; padding:8px;">

          <label>Instrucciones:</label>
          <textarea name="instruccion" id="editor" required placeholder="Ej: Resolver del 1 al 10" rows="15" style="width:100%; margin-bottom:10px; padding:8px;"></textarea>


            <label>Archivo (PDF, DOCX, PPTX, ZIP) (opcional):</label>
            <input type="file" name="archivo" accept=".pdf,.docx,.pptx,.zip" style="margin-bottom:15px;">

       <button type="submit" name="subir_material" class="mat-submit-btn" style="padding:10px 20px; background:#007BFF; color:white; border:none; border-radius:5px;">Enviar para revisión</button>
  </form>



  <form class="mat-suggest" action="sugerencia.php" method="POST">
    <h3>📝 Enviar Sugerencia o Comentario</h3>
    <textarea name="mensaje" rows="4" placeholder="Escribe tu comentario..." required></textarea>
    <button type="submit" class="mat-submit-btn">Enviar sugerencia</button>
  </form>

  </div>
  <!-- Popup para mostrar contenido de materiales -->
<div id="popup-material" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
  <div style="background:white; padding:20px; border-radius:10px; max-width:600px; width:90%; max-height:80vh; overflow:auto; position:relative;">
    <button onclick="cerrarPopup()" style="position:absolute; top:10px; right:10px; background:red; color:white; border:none; padding:5px 10px; border-radius:4px;">✖</button>
    <h3 id="popup-titulo" style="margin-top:0;"></h3>
    <pre id="popup-contenido" style="white-space:pre-wrap; font-family:inherit;"></pre>
  </div>
</div>

  </div>
  </main>
  <style>
    .mat-upload {
      max-width: 600px;
      margin: 40px auto;
      background: #ffffffee;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      font-family: "Segoe UI", sans-serif;
    }

    .mat-upload h3 {
      margin-bottom: 10px;
      font-size: 1.6em;
      color: #333;
    }

    .mat-upload p {
      margin-bottom: 20px;
      color: #555;
    }

    .mat-upload label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #222;
    }

    .mat-upload input[type="text"],
    .mat-upload input[type="file"],
    .mat-upload textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 1em;
      transition: border-color 0.3s;
    }

    .mat-upload input:focus,
    .mat-upload textarea:focus {
      outline: none;
      border-color: #007bff;
    }

    .mat-upload textarea {
      resize: vertical;
    }

    .mat-submit-btn {
      margin-top: 25px;
      width: 100%;
      padding: 12px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1em;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .mat-submit-btn:hover {
      background-color: #0056b3;
    }
  </style>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }

    function showMatTab(tabId) {
      const tabs = document.querySelectorAll('.mat-tab-content');
      const buttons = document.querySelectorAll('.mat-tab-btn');

      tabs.forEach(tab => tab.classList.remove('active'));
      buttons.forEach(btn => btn.classList.remove('active'));

      document.getElementById(tabId).classList.add('active');
      event.target.classList.add('active');
    }
  </script>
      <script src="nodes.js"></script>
  <script>
    // Abrir popup según data-popup
    document.querySelectorAll('ul li button').forEach(btn => {
      btn.addEventListener('click', () => {
        const popupId = 'popup-' + btn.dataset.popup;
        const popup = document.getElementById(popupId);
        if (popup) popup.classList.add('active');
      });
    });

    // Función para cerrar popup
    function cerrarPopup(id) {
      const popup = document.getElementById('popup-' + id);
      if (popup) popup.classList.remove('active');
    }

    // Cerrar popup al hacer click fuera del contenido
    document.querySelectorAll('.popup').forEach(popup => {
      popup.addEventListener('click', e => {
        if (e.target === popup) {
          popup.classList.remove('active');
        }
      });
    });
  </script>
  <style>
    
      ul {
      list-style: none;
      padding-left: 0;
    }
    ul li button {
      all: unset;
      cursor: pointer;
      color: #111;
      display: block;
      padding: 8px 0;
      width: 100%;
      text-align: left;
      font-size: 1rem;
    }
    ul li button:hover {
      text-decoration: underline;
      background-color: rgb(223, 223, 223);
    }

    /* Popup (oculto por defecto) */
    .popup {
      position: fixed;
      top:0; left:0; right:0; bottom:0;
      background: rgba(0,0,0,0.6);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 9999;
    }
    .popup.active {
      display: flex;
    }
    .popup-content {
      background: white;
      color: #111;
      padding: 20px;
      border-radius: 10px;
      max-width: 500px;
      max-height: 80vh;
      overflow-y: auto;
      position: relative;
    }
    .popup-content img {
      max-width: 100%;
      height: auto;
      margin: 10px 0;
    }
    .popup-close {
      position: absolute;
      right: 15px;
      top: 10px;
      font-weight: bold;
      font-size: 24px;
      cursor: pointer;
    }
    .ck-editor__editable_inline {
  min-height: 200px;
}

  </style>
<script>
  const form = document.querySelector('.mat-upload');
  
  form.addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(form);

    fetch('upload_material.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Error al enviar el formulario');
      return response.text();
    })
    .then(data => {
      alert('✅ Enviado correctamente');
      form.reset();
    })
    .catch(error => {
      alert('❌ Ocurrió un error, intenta de nuevo');
      console.error(error);
    });
  });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/41.0.1/classic/ckeditor.js"></script>
<script>
  ClassicEditor
    .create(document.querySelector('#editor'), {
      toolbar: ['heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'fontSize', 'undo', 'redo'],
    })
    .catch(error => {
        console.error(error);
    });
</script>
<!--temas popup-->
<script>
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".abrir-popup").forEach(btn => {
    btn.addEventListener("click", function () {
      const titulo = this.dataset.titulo;
      const contenido = this.dataset.contenido.replace(/\\n/g, "<br>");
      document.getElementById("popup-titulo").textContent = titulo;
      document.getElementById("popup-contenido").innerHTML = contenido;
      document.getElementById("popup-material").style.display = "flex";
    });
  });
});

function cerrarPopup() {
  document.getElementById("popup-material").style.display = "none";
}


function cerrarPopup() {
  document.getElementById("popup-material").style.display = "none";
}
</script>

  <footer>
  <div class="footer-contenido">
    <div class="footer-col">
      <h3>📘 Información de Ofimática</h3>
<p>Descubre todo lo que puedes hacer desde nuestra plataforma: explora el campo de acción, simula tu inscripción, conoce los beneficios de becas y auxiliaturas, visualiza y comparte material de apoyo, y accede a muchas más herramientas para potenciar tu formación académica y digital.</p>
    </div>

    <div class="footer-col">
      <h4>📍 Dirección</h4>
      <p>Av. 2do anillo Esq. Bush Modulo 212</p>
      
    </div>

    <div class="footer-col">
      <h4>📞 Teléfono</h4>
      <p>+591 77777777</p>
      <h4>✉️ Correo</h4>
      <p>correo@gmail.com</p>
    </div>
  </div>

  <div class="footer-bottom">
    <p>&copy; 2025 Liceniatura en Ofimática. Todos los derechos reservados.</p>
    <p>Desarrollado por <strong>Estefany Paz</strong></p>
  </div>
</footer>
  </body>
  </html>
