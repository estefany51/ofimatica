<?php
$dir = "pendientes/";
if (!is_dir($dir)) mkdir($dir);

if ($_FILES["archivo"]["error"] === 0) {
  $nombre = basename($_FILES["archivo"]["name"]);
  $destino = $dir . time() . "_" . $nombre;
  move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino);
  echo "Archivo enviado para revisión.";
  // Aquí puedes guardar ruta y fecha en una base de datos si quieres
} else {
  echo "Error al subir archivo.";
}
?>
