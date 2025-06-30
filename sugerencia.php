<?php
$comentario = strip_tags($_POST["mensaje"]);
file_put_contents("sugerencias.txt", date("Y-m-d H:i") . " - " . $comentario . "\n", FILE_APPEND);
echo "Comentario enviado para revisión.";
?>
