<?php
header('Content-Type: application/json');

// Carpetas
$dirPendientes = __DIR__ . '/pendientes/';
$dirArchivos = $dirPendientes . 'archivos/';

// Crear carpetas si no existen
if (!is_dir($dirPendientes)) mkdir($dirPendientes, 0755, true);
if (!is_dir($dirArchivos)) mkdir($dirArchivos, 0755, true);

// Recoger datos del formulario
$nombre = $_POST['nombre'] ?? '';
$registro = $_POST['registro'] ?? '';
$materia = $_POST['materia'] ?? '';
$titulo = $_POST['titulo'] ?? '';
$instruccion = $_POST['instruccion'] ?? '';

if (!$nombre || !$registro || !$materia || !$titulo || !$instruccion) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan datos obligatorios']);
    exit;
}

// Procesar archivo
$archivo_nombre = '';
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $tmpName = $_FILES['archivo']['tmp_name'];
    $originalName = basename($_FILES['archivo']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $allowed = ['pdf', 'docx', 'pptx', 'zip'];

    if (!in_array(strtolower($ext), $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Tipo de archivo no permitido']);
        exit;
    }

    $baseName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
    $archivo_nombre = $baseName . '.' . $ext;
    $destinoArchivo = $dirArchivos . $archivo_nombre;

    if (!move_uploaded_file($tmpName, $destinoArchivo)) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al guardar el archivo']);
        exit;
    }
}

// Crear archivo .txt para admin.php
$nombreTxt = pathinfo($archivo_nombre, PATHINFO_FILENAME) ?: time();
$contenidoTxt = $materia . "\n" .
                $titulo . "\n" .
                $nombre . "\n" .
                $registro . "\n" .
                $instruccion . "\n";

file_put_contents($dirPendientes . $nombreTxt . '.txt', $contenidoTxt);

// Guardar también en JSON si lo deseas
$data = [
    'fecha' => date('Y-m-d H:i:s'),
    'nombre' => $nombre,
    'registro' => $registro,
    'materia' => $materia,
    'titulo' => $titulo,
    'instruccion' => $instruccion,
    'archivo' => $archivo_nombre
];

$jsonFile = __DIR__ . '/materiales.json';
$materiales = [];

if (file_exists($jsonFile)) {
    $contenido = file_get_contents($jsonFile);
    $materiales = json_decode($contenido, true);
    if (!is_array($materiales)) {
        $materiales = [];
    }
}

$materiales[] = $data;
file_put_contents($jsonFile, json_encode($materiales, JSON_PRETTY_PRINT));

echo json_encode(['success' => true, 'message' => 'Material enviado correctamente']);
?>
