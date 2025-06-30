<?php
$authUser = "admin";
$authPass = "1234";

function limpiarEtiquetasBr($texto) {
  return str_replace(['<br>', '<br/>', '<br />'], "\n", $texto);
  
}

if (!isset($_SERVER['PHP_AUTH_USER']) ||
    $_SERVER['PHP_AUTH_USER'] !== $authUser ||
    $_SERVER['PHP_AUTH_PW'] !== $authPass) {
  header('WWW-Authenticate: Basic realm="Zona protegida"');
  header('HTTP/1.0 401 Unauthorized');
  echo 'Acceso denegado';
  exit;
}

$dir = "pendientes/";
$archivosDir = $dir . "archivos/";

// Crear carpeta archivos si no existe
if (!is_dir($archivosDir)) {
    mkdir($archivosDir, 0755, true);
}

$sugerencias = "sugerencias.txt";
$auxiliaturas = "auxiliaturas.txt";
$salas = "salas.txt";

$materiaPath = [
  "Temas" => "temas.txt",
  "Teleinformatica" => "teleinformatica.txt",
  "Sistemas" => "sistemas.txt",
  "Programacion" => "programacion.txt",
  "Sitios" => "sitios.txt"
];

// 🗑️ Eliminar materiales seleccionados
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar_seleccionados']) && isset($_POST['eliminar_materiales'])) {
  $seleccionados = $_POST['eliminar_materiales'];
  foreach ($seleccionados as $item) {
    list($materia, $index) = explode("|", $item);
    if (isset($materiaPath[$materia]) && file_exists($materiaPath[$materia])) {
      $archivo = $materiaPath[$materia];
      $lineas = file($archivo);
      unset($lineas[(int)$index]);
      file_put_contents($archivo, implode("", $lineas));
    }
  }
  header("Location: admin.php?tab=material");
  exit;
}

// ✅ Aprobar y mover material desde Archivos a la materia correspondiente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aprobar_material'])) {
  $materia = trim($_POST['materia']);
  $titulo = trim($_POST['titulo']);
  $instruccion = limpiarEtiquetasBr($_POST['instruccion']);
  $archivoNombre = trim($_POST['archivo_pendiente']);
  $archivoAdjunto = isset($_POST['archivo_adjunto']) ? trim($_POST['archivo_adjunto']) : '';

  $archivo_pendiente = $dir . basename($archivoNombre);

  if (!file_exists($archivo_pendiente)) {
    die("❌ El archivo pendiente no existe.");
  }

  $lineas = file($archivo_pendiente, FILE_IGNORE_NEW_LINES);

  $materia_archivo   = $lineas[0] ?? '';
  $titulo_archivo    = $lineas[1] ?? '';
  $nombre            = $lineas[2] ?? '';
  $registro          = $lineas[3] ?? '';
  $instruccion = implode("\n", array_slice($lineas, 4));
  $instruccion = limpiarEtiquetasBr($instruccion);

echo "<li style='margin-bottom:20px; padding:10px; border:1px solid #ddd; border-radius:8px;'>
          <strong>📘 " . htmlspecialchars($materia) . "</strong><br>
          <span>🏷️ " . htmlspecialchars($titulo) . "</span>

          <div style='background:#f8f8f8; padding:10px; border-radius:6px; white-space:pre-wrap; margin-top:8px;'>
            📝 <strong>Instrucciones:</strong>
            <br>
            " . htmlspecialchars($instruccion) . "
          </div>
        </li>";

if (!isset($materiaPath[$materia])) {
    $archivoNuevo = strtolower(preg_replace('/[^a-z0-9]/i', '_', $materia)) . ".txt";
    $materiaPath[$materia] = $archivoNuevo;
  }
  $materiaArchivo = $materiaPath[$materia];

  // Aquí estaba una variable $instruccion_extra no definida, la corregí por $instruccion
  $entrada = "$materia|$titulo|" . str_replace(["\r", "\n"], ["", "\\n"], $instruccion) . "|" . $archivoAdjunto;
  file_put_contents($materiaArchivo, $entrada . "\n", FILE_APPEND);
  unlink($archivo_pendiente);

  header("Location: admin.php?tab=material");
  exit;
}

// 📤 Procesar envío desde material.html
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subir_material'])) {

  $materia     = trim($_POST['materia']);
  $titulo      = trim($_POST['titulo']);
  $instruccion = htmlspecialchars(trim($_POST['instruccion']));
  $nombre      = htmlspecialchars(trim($_POST['nombre']));
  $registro    = htmlspecialchars(trim($_POST['registro']));

  $contenidoArchivo = $materia . "\n" .
                      $titulo . "\n" .
                      $nombre . "\n" .
                      $registro . "\n" .
                      $instruccion . "\n";

  $archivoLink = '';
  if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['archivo']['tmp_name'];
    $original = basename($_FILES['archivo']['name']);
    if ($tmp && file_exists($tmp)) {
      $nombreFinal = time() . "-" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $original);
      $extension = pathinfo($original, PATHINFO_EXTENSION);
      $nombreBase = time() . "-" . preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", pathinfo($original, PATHINFO_FILENAME));
      $nombreFinal = $nombreBase . "." . $extension;

      $destinoTxt = $dir . $nombreBase . ".txt";  // solo el archivo con datos de texto
      $destinoArchivo = $archivosDir . $nombreFinal; // archivo adjunto con extensión original

      file_put_contents($destinoTxt, $contenidoArchivo);
      move_uploaded_file($tmp, $destinoArchivo);

      $archivoLink = "<p><strong>📎 Archivo adjunto:</strong> <a href='" . htmlspecialchars($destinoArchivo) . "' target='_blank'>" . htmlspecialchars($original) . "</a></p>";
    }
  } else {
    $nombreFinal = time() . ".txt";
    $destinoTxt = $dir . $nombreFinal;
    file_put_contents($destinoTxt, $contenidoArchivo);
  }

  // Mostrar resultado visual directamente
  echo '
  <div style="max-width:700px;margin:40px auto;background:#fff;border:1px solid #ddd;padding:30px;border-radius:10px;font-family:sans-serif;">
    <h3>📄 Nuevo Material Recibido</h3>
    <p><strong>👤 Nombre completo:</strong> ' . $nombre . '</p>
    <p><strong>🆔 Registro:</strong> ' . $registro . '</p>
    <p><strong>📘 Materia:</strong> ' . $materia . '</p>
    <p><strong>📌 Título:</strong> ' . $titulo . '</p>
    
    <h4>📝 Instrucciones:</h4>
    <p>' . $instruccion . '</p>
    ' . $archivoLink . '
    <p style="margin-top:20px;color:gray;">Este contenido fue enviado desde el formulario de material de apoyo.</p>
  </div>';
  exit;
}

// 🗑️ Eliminar archivo
if (isset($_GET["eliminar"])) {
  $file = basename($_GET["eliminar"]);
  $path = $dir . $file;
  if (file_exists($path)) unlink($path);
  header("Location: admin.php");
  exit;
}

// 🗑️ Borrar sugerencia
if (isset($_GET["borrar_sug"])) {
  $i = intval($_GET["borrar_sug"]);
  $lines = file($sugerencias);
  unset($lines[$i]);
  file_put_contents($sugerencias, implode("", $lines));
  header("Location: admin.php");
  exit;
}

// 💾 Guardar auxiliaturas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_aux'])) {
  if (isset($_POST['aux']) && is_array($_POST['aux'])) {
    $lineas = [];
    foreach ($_POST['aux'] as $fila) {
      $lineas[] = implode("|", array_map('trim', $fila));
    }
    file_put_contents($auxiliaturas, implode("\n", $lineas));
  }
  header("Location: admin.php?tab=aux");
  exit;
}

// --------------- NUEVO: Mostrar listado de materiales pendientes ---------------
function mostrarMaterialesPendientes($dir, $archivosDir) {
    echo "<h2>Materiales Pendientes</h2>";
    if (!is_dir($dir)) {
        echo "<p>No existe la carpeta pendientes.</p>";
        return;
    }
    $archivos = scandir($dir);
    $txts = array_filter($archivos, function($f) use ($dir) {
        return is_file($dir . $f) && pathinfo($f, PATHINFO_EXTENSION) === "txt";
    });
    if (empty($txts)) {
        echo "<p>No hay materiales pendientes.</p>";
        return;
    }
    echo "<ul>";
    foreach ($txts as $txt) {
        $contenido = file($dir . $txt, FILE_IGNORE_NEW_LINES);
        $materia = $contenido[0] ?? "(sin materia)";
        $titulo = $contenido[1] ?? "(sin título)";
        $nombre = $contenido[2] ?? "(sin nombre)";
        $registro = $contenido[3] ?? "(sin registro)";
        echo "<li><strong>$titulo</strong> - $materia<br>";
        echo "Por: $nombre (Registro: $registro)<br>";
        // Buscar si hay archivo adjunto con nombre parecido (sin extensión .txt)
        $base = pathinfo($txt, PATHINFO_FILENAME);
        $archivoAdj = glob($archivosDir . $base . "*");
        if ($archivoAdj) {
        $archivoWeb = "pendientes/archivos/" . basename($archivoAdj[0]);
        echo "Archivo adjunto: <a href='" . htmlspecialchars($archivoWeb) . "' target='_blank'>" . basename($archivoAdj[0]) . "</a>";
        }
        echo "</li><hr>";
    }
    echo "</ul>";
}

// Si quieres mostrar el listado, descomenta esta línea:
// mostrarMaterialesPendientes($dir, $archivosDir);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f0f2f5;
    }
    .admin-container {
      display: flex;
      height: 100vh;
    }
    .sidebar {
      width: 220px;
      background: #1e1f26;
      color: white;
      padding: 20px;
    }
    .sidebar h2 {
      font-size: 18px;
      margin-bottom: 20px;
    }
    .sidebar button {
      width: 100%;
      padding: 10px;
      background: none;
      border: none;
      color: white;
      text-align: left;
      cursor: pointer;
      font-size: 16px;
      border-bottom: 1px solid #333;
    }
    .sidebar button:hover {
      background: #2c2f3a;
    }
    .main {
      flex: 1;
      padding: 30px;
      overflow-y: auto;
    }
    h3 {
      color: #333;
    }
    .box {
      background: white;
      padding: 20px;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    ul { list-style: none; padding: 0; }
    li { margin-bottom: 10px; }
    a.btn {
      padding: 6px 12px;
      border-radius: 5px;
      text-decoration: none;
      background: #007BFF;
      color: white;
      margin-left: 10px;
    }
    a.btn.red {
      background: #d9534f;
    }
    textarea {
      width: 100%;
      height: 250px;
      font-family: monospace;
      font-size: 14px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }
    .btn-save {
      margin-top: 10px;
      background: green;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="admin-container">
  <div class="sidebar">
    <h2>🔐 Admin Panel</h2>
    <button onclick="showTab('archivos')">📂 Archivos</button>
    <button onclick="showTab('sugerencias')">📝 Sugerencias</button>
    <button onclick="showTab('aux')">📘 Auxiliaturas</button>
    <button onclick="showTab('salas')">💻 Salas Cómputo</button>
    <button onclick="showTab('usuarios')">👥 Usuarios</button>
    <button onclick="showTab('material')">👥 Material</button>
  </div>
  <div class="main">
    
<div id="tab-archivos" class="tab box">
  <h3>📂 Archivos Pendientes</h3>
  <ul>
    <?php
    $archivos = glob($dir . "*");

    if (count($archivos) == 0) {
      echo "<p>No hay archivos pendientes.</p>";
    } else {
      foreach ($archivos as $archivo) {
        if (pathinfo($archivo, PATHINFO_EXTENSION) !== 'txt') continue;

        $nombre_archivo = basename($archivo);
        $lineas = file($archivo, FILE_IGNORE_NEW_LINES);

        $materia   = $lineas[0] ?? "Sin materia";
        $titulo    = $lineas[1] ?? "Sin título";
        $nombre    = $lineas[2] ?? "Desconocido";
        $registro  = $lineas[3] ?? "N/D";
        $instruccion = implode("\n", array_slice($lineas, 4));
        $instruccion = limpiarEtiquetasBr($instruccion);

        // Buscar archivo adjunto
        $base = pathinfo($nombre_archivo, PATHINFO_FILENAME);
        $documento = null;
        foreach (glob($archivosDir . $base . "*") as $archivoRelacionado) {
          if (pathinfo($archivoRelacionado, PATHINFO_EXTENSION) !== 'txt') {
            $documento = $archivoRelacionado;
            break;
          }
        }

       echo "<li style='margin-bottom:20px; padding:10px; border:1px solid #ddd; border-radius:8px;'>
        <strong>📘 " . htmlspecialchars($materia) . "</strong><br>
        <span>🏷️ " . htmlspecialchars($titulo) . "</span>

        <div style='background:#f8f8f8; padding:10px; border-radius:6px; white-space:pre-wrap; margin-top:8px; line-height:1.1;'>
          📝 <strong>Instrucciones:</strong>
          <br>
          " . htmlspecialchars($instruccion) . "
        </div>
      </li>";


        if ($documento) {
          echo "<div style='margin-top:10px;'>
                  <a href='" . htmlspecialchars($documento) . "' target='_blank' class='btn'>📄 Abrir documento</a>
                </div>";
        }

        echo "<br><span>👤 Enviado por: " . htmlspecialchars($nombre) . " (Registro: " . htmlspecialchars($registro) . ")</span><br><br>";

       // Formulario para aprobar o eliminar
echo "<form method='POST' action='admin.php?tab=archivos' style='display:inline; margin-left:10px;'>
        <input type='hidden' name='aprobar_material' value='1'>
        <input type='hidden' name='archivo_pendiente' value='" . htmlspecialchars($nombre_archivo) . "'>
        <input type='hidden' name='titulo' value='" . htmlspecialchars($titulo) . "'>
        <input type='hidden' name='instruccion' value='" . htmlspecialchars(str_replace("\n", "\\n", $instruccion)) . "'>
        <input type='hidden' name='materia_original' value='" . htmlspecialchars($materia) . "'>";
        
      // ➕ NUEVO: incluir nombre del archivo adjunto si existe
      if ($documento) {
    echo "<input type='hidden' name='archivo_adjunto' value='" . htmlspecialchars(basename($documento)) . "'>";
      }

      echo "<input list='materias' name='materia' value='" . htmlspecialchars($materia) . "' required style='padding:5px;'>
        <datalist id='materias'>" .
          implode('', array_map(fn($m) => "<option value='" . htmlspecialchars($m) . "'>", array_keys($materiaPath))) .
        "</datalist>

        <button type='submit' class='btn' style='background:green; color:white;'>Agregar</button>
      </form>

      <a href='?eliminar=" . urlencode($nombre_archivo) . "&tab=archivos' class='btn red' style='margin-left:10px;'>❌ Rechazar</a>
    </li>";

      }
    }
    ?>
  </ul>
</div>

<div id="tab-aux" class="tab box" style="display:none;">
  <h3>📘 Editar Auxiliaturas y Horarios</h3>
  <form method="post">
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse: collapse;">
      <thead style="background:#eaeaea">
        <tr>
          <th>Materia</th>
          <th>Nombre Auxiliar</th>
          <th>Horario 1</th>
          <th>Aula 1</th>
          <th>Horario 2</th>
          <th>Aula 2</th>
        </tr>
      </thead>
      <tbody id="tabla-aux">
        <?php
        if (file_exists($auxiliaturas)) {
          $filas = file($auxiliaturas);
          foreach ($filas as $i => $linea) {
            $datos = explode("|", trim($linea));
            while (count($datos) < 6) $datos[] = ""; // completar si faltan columnas
            echo "<tr>";
            for ($j = 0; $j < 6; $j++) {
              echo "<td><input name='aux[$i][$j]' value='" . htmlspecialchars(trim($datos[$j])) . "' style='width:100%;'></td>";
            }
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
    <br>
    <button type="button" onclick="agregarFila()">➕ Agregar fila</button>
    <button class="btn-save" type="submit">💾 Guardar cambios</button>
    <input type="hidden" name="guardar_aux" value="1">
  </form>
</div>

<div id="tab-salas" class="tab box" style="display:none;">
  <h3>💻 Salas de Cómputo por Turno</h3>
  <form method="post">
    <table border="1" cellpadding="6" cellspacing="0" style="width:100%; border-collapse: collapse;">
      <thead style="background:#f7f7f7">
        <tr>
          <th>Turno</th>
          <th>Nombre Auxiliar</th>
          <th>Horario (editable)</th>
        </tr>
      </thead>
      <tbody id="tabla-salas">
        <?php
        if (file_exists($salas)) {
          $filas = file($salas);
          foreach ($filas as $i => $linea) {
            $datos = explode("|", trim($linea));
            while (count($datos) < 3) $datos[] = "";
            echo "<tr>";
            echo "<td>
                    <select name='salas[$i][0]' style='width:100%'>
                      <option value='mañana' " . ($datos[0] == 'mañana' ? 'selected' : '') . ">Mañana</option>
                      <option value='tarde' " . ($datos[0] == 'tarde' ? 'selected' : '') . ">Tarde</option>
                      <option value='noche' " . ($datos[0] == 'noche' ? 'selected' : '') . ">Noche</option>
                    </select>
                  </td>";
            echo "<td><input name='salas[$i][1]' value='" . htmlspecialchars($datos[1]) . "' style='width:100%'></td>";
            echo "<td><input name='salas[$i][2]' value='" . htmlspecialchars($datos[2]) . "' style='width:100%'></td>";
            echo "</tr>";
          }
        }
        ?>
      </tbody>
    </table>
    <br>
    <button type="button" onclick="agregarFilaSala()">➕ Agregar auxiliar</button>
    <button class="btn-save" type="submit">💾 Guardar cambios</button>
    <input type="hidden" name="guardar_salas" value="1">
  </form>
</div>

<div id="tab-material" class="tab box" style="display:none;">
  <div style="max-width:900px; margin:30px auto; padding:30px; background:#fff; border:1px solid #ddd; border-radius:10px; font-family:sans-serif;">
    <h3>📚 Materiales Aprobados</h3>
    <p style="margin-bottom:15px;">Selecciona una materia para ver los materiales disponibles. Puedes eliminar varios a la vez si lo deseas.</p>

    <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:30px;">
      <?php foreach ($materiaPath as $clave => $archivo): ?>
        <button onclick="mostrarMaterial('<?php echo $clave; ?>')" style="padding:10px 15px; border:none; border-radius:6px; background:#007bff; color:white; cursor:pointer;">
          📘 <?php echo htmlspecialchars($clave); ?>
        </button>
      <?php endforeach; ?>
    </div>

    <?php foreach ($materiaPath as $clave => $archivo): ?>
      <div id="material-<?php echo $clave; ?>" class="bloque-material" style="display:none; margin-top:20px;">
        <h4 style="color:#333;">📘 <?php echo htmlspecialchars($clave); ?></h4>
        <?php
        if (file_exists($archivo)) {
          $lineas = file($archivo);
          echo "<form method='POST' onsubmit='return confirm(\"¿Eliminar los materiales seleccionados?\")'>";
          echo "<ol style='padding-left:20px;'>";
          foreach ($lineas as $index => $linea) {
$partes = explode("|", $linea);
$id = $partes[0] ?? '';
$titulo = $partes[1] ?? '';
$contenido = str_replace("\\n", "\n", $partes[2] ?? '');
$archivoAdjunto = $partes[3] ?? '';
            $contenido = str_replace("\\n", "\n", $contenido);
            $key = $clave . "|" . $index;

            echo "<li style='margin-bottom:20px; background:#f9f9f9; padding:15px; border-radius:8px; border:1px solid #eee;'>
  <label style='display:flex; align-items:flex-start; gap:10px;'>
    <input type='checkbox' name='eliminar_materiales[]' value='" . htmlspecialchars($key) . "' style='margin-top:5px;'>
    <div>
      <strong style='color:#222; font-size:16px;'>" . htmlspecialchars($titulo) . "</strong><br>
      <pre style='background:#f4f4f4; padding:10px; border-radius:6px; white-space:pre-wrap; font-family:inherit;'>" . htmlspecialchars(trim($contenido)) . "</pre>";

if ($archivoAdjunto) {
    $ruta = "pendientes/archivos/" . $archivoAdjunto;
    $ext = strtolower(pathinfo($archivoAdjunto, PATHINFO_EXTENSION));
    echo "<div style='margin-top:10px;'>";
    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
        echo "<img src='" . htmlspecialchars($ruta) . "' style='max-width:300px; border:1px solid #ccc; border-radius:6px;'>";
    } else {
        echo "<a href='" . htmlspecialchars($ruta) . "' target='_blank' style='color:#007BFF;'>📎 Ver archivo adjunto</a>";
    }
    echo "</div>";
}

echo "    </div>
  </label>
</li>";

          }
          echo "</ol>";
          echo "<button type='submit' name='eliminar_seleccionados' style='padding:10px 15px; background:#d9534f; color:white; border:none; border-radius:6px; margin-top:15px;'>❌ Eliminar seleccionados</button>";
          echo "<input type='hidden' name='materia_actual' value='" . htmlspecialchars($clave) . "'>";
          echo "</form>";
        } else {
          echo "<p style='font-style:italic; color:gray;'>Sin materiales registrados aún para esta materia.</p>";
        }
        ?>
      </div>
    <?php endforeach; ?>
  </div>
</div>



  </div>
</div>

<script>
function showTab(id) {
  document.querySelectorAll('.tab').forEach(tab => tab.style.display = 'none');
  document.getElementById('tab-' + id).style.display = 'block';
}
<?php
// Mostrar directamente una pestaña si se indica por GET (como ?tab=aux)
if (isset($_GET['tab'])) {
  echo "showTab('" . htmlspecialchars($_GET['tab']) . "');";
}
?>
</script>
<!--aux-->
<script>
function agregarFila() {
  const tabla = document.getElementById("tabla-aux");
  const nueva = document.createElement("tr");
  for (let i = 0; i < 6; i++) {
    const td = document.createElement("td");
    const input = document.createElement("input");
    input.name = `aux[${tabla.rows.length}][${i}]`;
    input.style.width = "100%";
    td.appendChild(input);
    nueva.appendChild(td);
  }
  tabla.appendChild(nueva);
}

function agregarFilaSala() {
  const tabla = document.getElementById("tabla-salas");
  const nueva = document.createElement("tr");

  const turno = document.createElement("td");
  turno.innerHTML = `<select name='salas[${tabla.rows.length}][0]' style='width:100%'>
                      <option value='mañana'>Mañana</option>
                      <option value='tarde'>Tarde</option>
                      <option value='noche'>Noche</option>
                    </select>`;
  nueva.appendChild(turno);

  const nombre = document.createElement("td");
  const inputNombre = document.createElement("input");
  inputNombre.name = `salas[${tabla.rows.length}][1]`;
  inputNombre.style.width = "100%";
  nombre.appendChild(inputNombre);
  nueva.appendChild(nombre);

  const horario = document.createElement("td");
  const inputHorario = document.createElement("input");
  inputHorario.name = `salas[${tabla.rows.length}][2]`;
  inputHorario.style.width = "100%";
  horario.appendChild(inputHorario);
  nueva.appendChild(horario);

  tabla.appendChild(nueva);
}

</script>

<!--material-->
<script>
function mostrarMaterial(materia) {
  document.querySelectorAll(".bloque-material").forEach(div => div.style.display = "none");
  document.getElementById("material-" + materia).style.display = "block";
}
</script>


</body>
</html>
