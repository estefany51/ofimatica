<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Malla Curricular</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  html, body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    overflow-x: hidden;
    overflow-y: auto;
  }

  .main-contents {
    max-width: 1000px;
    margin: 40px 20px 50px 20px;
    padding: 20px;
    display: block;
    min-height: auto;
    text-align: center;
  }

  .main-contents h1 {
    font-size: 3em;
    color: #ffffff;
    margin-bottom: 40px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
  }

  .tabs {
    display: flex;
    flex-wrap: nowrap;
    justify-content: flex-start;
    gap: 2px;
    margin-bottom: 1.3rem;
    padding: 4px 0;
  }

  .tab-content {
    margin-top: 1rem;
    border-radius: 10px;
    padding: 1rem;
  }

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
  width: 100%;
  gap: 10px; /* ✅ Espacio entre columnas */
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
      <button class="toggle-aux-btn" onclick="toggleAuxBar()">📘 AUXILIATURAS</button>
      <aside class="aux-bar collapsed" id="auxBar">
          <h3>📘 Auxiliaturas <br>Cátedra</h3>
            <ul>
            <?php
$auxiliaturas = "auxiliaturas.txt";
if (file_exists($auxiliaturas)) {
  $filas = file($auxiliaturas);
  foreach ($filas as $linea) {
    $datos = explode("|", trim($linea));
    if (count($datos) >= 2) {
      $materia = htmlspecialchars($datos[0]);
      $auxiliar = htmlspecialchars($datos[1]);
      $hor1 = isset($datos[2]) ? htmlspecialchars($datos[2]) : "";
      $aula1 = isset($datos[3]) ? htmlspecialchars($datos[3]) : "";
      $hor2 = isset($datos[4]) ? htmlspecialchars($datos[4]) : "";
      $aula2 = isset($datos[5]) ? htmlspecialchars($datos[5]) : "";

      echo "<li onclick='toggleDetalle(this)'>";
      echo "$materia";
      echo "<div class='detalle'>";
      echo "<strong>Auxiliar:</strong> $auxiliar<br>";
      if ($hor1) echo "<strong>Horario:</strong> $hor1<br><strong>Aula:</strong> $aula1<br>";
      if ($hor2) echo "<strong>Horario:</strong> $hor2<br><strong>Aula:</strong> $aula2<br>";
      echo "</div></li>";
    }
  }
} else {
  echo "<li><em>No hay auxiliaturas cargadas.</em></li>";
            }
          ?>
            </ul>
          <h3>📘 Auxiliaturas<br> Salas de Cómputo</h3>
            <ul>
<?php
$salas = "salas.txt";
$turnos = ["mañana" => [], "tarde" => [], "noche" => []];

if (file_exists($salas)) {
  $lineas = file($salas);
  foreach ($lineas as $linea) {
    $partes = explode("|", trim($linea));
    if (count($partes) == 3) {
      list($turno, $nombre, $horario) = $partes;
      $turnos[$turno][] = ["nombre" => $nombre, "horario" => $horario];
    }
  }

  foreach ($turnos as $turno => $datos) {
    if (count($datos) == 0) continue;

    $nombres = array_column($datos, "nombre");
    $horario = htmlspecialchars($datos[0]["horario"]);

    echo "<li onclick=\"toggleDetalle(this)\">";
    echo "Turno " . ucfirst($turno);
    echo "<div class='detalle'>";
    echo "<strong>Auxiliar:</strong> " . implode("<br>", array_map('htmlspecialchars', $nombres)) . "<br>";
    echo "<strong>Horario:</strong> Lun a vie " . $horario . "<br>";
    echo "</div></li>";
  }
} else {
  echo "<li><em>No hay datos disponibles.</em></li>";
}
?>
            </ul>
          <p><strong>Nota:</strong> Los horarios pueden estar sujetos a cambios.<br>Horario de atención en salas está establecido a atención a docente. <br> Hora máxima de atención a estudiante 08:30pm<br></p><p></p><p><br></p>
      </aside>

  <div class="main-contents">
    <table style="width: 100%;">
      <tr style="padding-bottom: 20px;">
        <td style="width: 70%; text-align: center; padding-bottom: 20px;">
        <h1 style="margin: 0;">MALLA CURRICULAR</h1>
        </td>
        <td style="width: 30%; text-align: right; padding-bottom: 20px;">
        <a href="simulacion.html" class="boton-simular">Simular Inscripción</a>
        </td>
                </tr>
    </table>
    <div class="tabs">
      <button class="tab-btn active" onclick="showTab(0)">SEM-1</button>
      <button class="tab-btn" onclick="showTab(1)">SEM-2</button>
      <button class="tab-btn" onclick="showTab(2)">SEM-3</button>
      <button class="tab-btn" onclick="showTab(3)">SEM-4</button>
      <button class="tab-btn" onclick="showTab(4)">SEM-5</button>
      <button class="tab-btn" onclick="showTab(5)">SEM-6</button>
      <button class="tab-btn" onclick="showTab(6)">SEM-7</button>
      <button class="tab-btn" onclick="showTab(7)">SEM-8</button>
    </div>
    <div class="tab-content">
      <div class="tab-pane active">
        <div class="materia"> 
          <h3 onclick="toggleDetalles(this)">Lenguaje I</h3>
          <div class="detalles">
                      <table class="tabla-detalles">
                        <tr>
                          <th>GRUPO</th>
                          <td>LEN312-I7</td>
                          <td>LEN312-I8</td>
                          <td>LEN312-OF</td>
                        </tr>
                        <tr>
                          <th>DOCENTE</th>
                          <td>ARDUZ VARGAS YENNY TERESA</td>
                          <td>CASTRO SUAREZ SOLIA</td>
                          <td>GALARZA DE EID MARIA ELIZABETH</td>
                        </tr>
                        <tr>
                          <th>HORARIO / AULA</th>
                          <td>Mié: 13:45 - 15:15 / 212-50<br>Sáb: 12:15 - 13:45 / 212-05</td>
                          <td>Lun: 21:15 - 22:45 / 212-01<br> Vie: 18:15 - 19:45 / 212-20</td>
                          <td>Mié: 08:30 - 11:30 / 212-13</td>
                        </tr>
                      </table>
          </div>
        </div>
        <div class="materia">
          <h3 onclick="toggleDetalles(this)">Matemática Básica</h3>
            <div class="detalles">
                        <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>MAT310-I7</td>
                  <td>MAT310-I8</td>
                  <td>MAT310-I9</td>
                  <td>MAT310-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>CASTRO CAMACHO JOSE ROBERTO</td>
                  <td>GUTIERREZ SUAREZ JOSE LIMBERG</td>
                  <td>MARIA DEL CARMEN RIBERA ROBLES</td>
                  <td>CASTRO CAMACHO JOSE ROBERTO</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Mar: 14:30 - 16:00 / 212-03<br>Jue: 14:30 - 16:00 / 212-03</td>
                  <td>Lun: 18:15 - 19:45 / 212-03<br>Mié: 18:15 - 19:45 / 212-03</td>
                  <td>Lun: 08:30 - 10:00 / 212-06<br>Vie: 08:30 - 10:00 / 212-10 </td>
                  <td>Mar: 07:00 - 08:30 / 212-06</td>
                </tr>
              </table>
            </div>
        </div>
        <div class="materia">
          <h3 onclick="toggleDetalles(this)">Inglés I</h3>
            <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>LEN311-I7</td>
                  <td>LEN311-I8</td>
                  <td>LEN311-I9</td>
                  <td>LEN311-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ZUÑIGA RUIZ WILMA</td>
                  <td>PIZARRO FRANCO CANDELARIA</td>
                  <td>PIZARRO FRANCO CANDELARIA</td>
                  <td>BENEGAS LIJERON MARIA DEL CARMEN</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Lun: 13:45 - 15:15 / 212-01<br>Mié: 15:15 - 16:45 / 212-01</td>
                  <td>Lun: 19:45 - 21:45 / 212-51<br>Mié: 19:45 - 21:45 / 212-01</td>
                  <td>Sáb: 11:30 - 14:30 / 212-01</td>
                  <td>Mié: 11:30 - 13:00 / 212-01<br>Vie: 11:30 - 13:00 / 212-01</td>
                </tr>
              </table>
            </div>
        </div>
        <div class="materia">
          <h3 onclick="toggleDetalles(this)">Electrónica General</h3>
            <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR111-I7</td>
                  <td>HAR111-I8</td>
                  <td>HAR111-0F</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GUTIERREZ SUAREZ JOSE LIMBERG </td>
                  <td>ARCE GALVIS SANTOS DOMINGO</td>
                  <td>CARVALLO GOMEZ JHONNY VLADIMIR</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Mar: 16:00 - 18:15 / 212-01<br>Jue: 16:00 - 18:15 / 212-01</td>
                  <td>Mar: 19:45 - 22:00 / 212-01<br>Jue: 19:45 - 22:00 / 212-01</td>
                  <td>Mar: 09:15 - 11:30 / 212-01<br>Jue: 09:15 - 11:30 / 212-01</td>
                </tr>
              </table>
            </div>
        </div>
        <div class="materia">
          <h3 onclick="toggleDetalles(this)">Realidad Nacional</h3>
            <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP210-I9</td>
                  <td>EMP210-0F</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ALLERDING VACA DORIS </td>
                  <td>ALLERDING VACA DORIS </td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Lun: 12:15 - 13:45 / 212-16<br>Mie: 12:15 - 13:45 / 212-16</td>
                  <td>Mar: 18:15 - 19:45 / 212-31<br>Jue: 18:15 - 19:45 / 212-07</td>
                </tr>
              </table>
            </div>
        </div>
        <div class="Horario">
          <h2>1er Semestre</h2>
            <div class="horario-wrapper">
              <table border="1" class="horario-table">
                <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="2">Lunes</th><th colspan="2">Martes</th><th colspan="2">Miércoles</th><th colspan="1">Jueves</th><th colspan="1">Viernes</th><th colspan="2">Sábado</th>
                </tr>
                </thead>
                <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
                <tr><td style="color: darkblue;">07:00</td><td style="color: darkblue;">07:45</td><td></td><td></td><td rowspan="2">MAT310<br>OF</td><td></td><td></td><td></td><td rowspan="2">MAT310<br>OF</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">07:45</td><td style="color: darkblue;">08:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">08:30</td><td style="color: darkblue;">09:15</td><td rowspan="2">MAT310<br>I9</td><td></td><td></td><td></td><td rowspan="2"style="background-color: orange;">LEN312<br>OF</td><td></td><td></td><td rowspan="2">MAT310<br>I9</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">09:15</td><td style="color: darkblue;">10:00</td><td></td><td rowspan="3" style="background-color: rgb(105, 188, 255);">HAR111<br>OF</td><td></td></td><td></td><td rowspan="3" style="background-color: rgb(105, 188, 255);">HAR111<br>OF</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">10:00</td><td style="color: darkblue;">10:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">10:45</td><td style="color: darkblue;">11:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">11:30</td><td style="color: darkblue;">12:15</td><td></td><td></td><td></td><td></td><td rowspan="2"  style="background-color: lightgreen;">LEN311<br>OF</td><td></td><td></td><td rowspan="2"  style="background-color: lightgreen;">LEN311<br>OF</td><td rowspan="4"  style="background-color: lightgreen;">LEN311<br>I9</td><td></td></tr>
                <tr><td style="color: darkblue;">12:15</td><td style="color: darkblue;">13:00</td><td rowspan="2" style="background-color: yellow;">EMP210<br>I9</td><td></td><td></td><td></td><td rowspan="2" style="background-color: yellow;">EMP210<br>I9</td><td></td><td rowspan="2" style="background-color: orange;">LEN312<br>I7</td></tr>
                <tr><td style="color: darkblue;">13:00</td><td style="color: darkblue;">13:45</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">13:45</td><td style="color: darkblue;">14:30</td><td rowspan="2" style="background-color: lightgreen;">LEN311<br>I7</td><td></td><td></td><td></td><td rowspan="2" style="background-color: orange;">LEN312<br>I7</td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">14:30</td><td style="color: darkblue;">15:15</td><td></td><td rowspan="2">MAT310<br>I7</td><td></td><td></td><td rowspan="2">MAT310<br>I7</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">15:15</td><td style="color: darkblue;">16:00</td><td></td><td></td><td></td><td rowspan="2"  style="background-color: lightgreen;">LEN311<br>I7</td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:00</td><td style="color: darkblue;">16:45</td><td></td><td></td><td rowspan="3" style="background-color: rgb(105, 188, 255);">HAR111<br>I7</td><td></td><td></td><td rowspan="3" style="background-color: rgb(105, 188, 255);">HAR111<br>I7</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:45</td><td style="color: darkblue;">17:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">17:30</td><td style="color: darkblue;">18:15</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">18:15</td><td style="color: darkblue;">19:00</td><td rowspan="2">MAT310<br>I8</td><td></td><td rowspan="2" style="background-color: yellow;">EMP210<br>OF</td><td></td><td rowspan="2">MAT310<br>I8</td><td></td><td rowspan="2" style="background-color: yellow;">EMP210<br>OF</td></td><td rowspan="2" style="background-color: orange;">LEN312<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:00</td><td style="color: darkblue;">19:45</td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:45</td><td style="color: darkblue;">20:30</td><td rowspan="2"  style="background-color: lightgreen;">LEN311<br>I8</td><td></td><td rowspan="3"style="background-color: rgb(105, 188, 255);">HAR111<br>I8</td><td></td><td rowspan="2"  style="background-color: lightgreen;">LEN311<br>I8</td><td></td><td rowspan="3" style="background-color: rgb(105, 188, 255);">HAR111<br>I8</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">20:30</td><td style="color: darkblue;">21:15</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">21:15</td><td style="color: darkblue;">22:00</td><td rowspan="2" style="background-color: orange;">LEN312<br>I8</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">22:00</td><td style="color: darkblue;">22:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      
                </tbody>
              </table>
            </div>
        </div>
      </div>
      <div class="tab-pane">
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Inglés II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>LEN323-I7</td>
                  <td>LEN323-I8</td>
                  <td>LEN323-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>BENEGAS LIJERON MARIA DEL CARMEN</td>
                  <td>BENEGAS LIJERON MARIA DEL CARMEN</td>
                  <td>PIZARRO FRANCO CANDELARIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Miércoles 15:15 - 16:45 / 212-14<br>
          Viernes 16:45 - 18:15 / 212-14
        </td>
                  <td>
          Miércoles 19:45 - 21:15 / 212-16<br>
          Viernes 18:15 - 19:45 / 212-18
        </td>
                  <td>
          Lunes 10:45 - 12:15 / 212-15<br>
          Jueves 09:15 - 10:45 / 212-09
        </td>
                </tr>
              </table>
  </div>
      </div>
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Lenguaje II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>LEN324-I6</td>
                  <td>LEN324-I9</td>
                  <td>LEN324-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>CASTRO SUAREZ SOLIA</td>
                  <td>CASTRO SUAREZ SOLIA</td>
                  <td>ARDUZ VARGAS YENNY TERESA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 16:45 - 18:15 / 212-16<br>
          Viernes 15:15 - 16:45 / 212-16
        </td>
                  <td>
          Lunes 19:45 - 21:15 / 212-16<br>
          Miércoles 18:15 - 19:45 / 212-16
        </td>
                  <td>
          Lunes 09:15 - 10:45 / 212-50<br>
          Sábado 10:45 - 12:15 / 212-13
        </td>
                </tr>
              </table>
  </div>
      </div>
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Cálculo I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>MAT311-I7</td>
                  <td>MAT311-I8</td>
                  <td>MAT311-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GUTIERREZ TITO ROMAN</td>
                  <td>GUTIERREZ SUAREZ JOSE LIMBERG</td>
                  <td>LICHTENSTEIN LECHUGA CLAUDIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 16:00 - 17:30 / 212-05<br>
          Miércoles 17:30 - 19:00 / 212-01<br>
          Jueves 18:15 - 19:45 / 212-01
        </td>
                  <td>
          Lunes 19:45 - 22:00 / 212-19<br>
          Viernes 19:45 - 22:00 / 212-06
        </td>
                  <td>
          Lunes 07:00 - 09:15 / 212-05<br>
          Viernes 07:00 - 09:15 / 212-05
        </td>
                </tr>
              </table>
  </div>
      </div>
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Introducción a la Informática</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI111-I6</td>
                  <td>OFI111-I7</td>
                  <td>OFI111-I8</td>
                  <td>OFI111-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>TAPIA FLORES LUIS PERCY</td>
                  <td>ROJAS RALDES PATRICIA</td>
                  <td>RIBERA ROBLES MARIA DEL CARMEN</td>
                  <td>RIBERA ROBLES MARIA DEL CARMEN</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 09:15 - 11:30 / 212-52<br>
          Jueves 09:15 - 11:30 / 212-52
        </td>
                  <td>
          Lunes 09:15 - 12:15 / 212-49<br>
          Viernes 08:30 - 10:00 / 212-49
        </td>
                  <td>
          Lunes 18:15 - 19:45 / 212-51<br>
          Miércoles 16:45 - 19:45 / 212-51
        </td>
                  <td>
          Martes 07:00 - 09:15 / 212-52<br>
          Jueves 07:00 - 09:15 / 212-49
        </td>
                </tr>
              </table>
  </div>
      </div>
          <div class="materia">
  <h3 onclick="toggleDetalles(this)">Productos de Oficina I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI122-I7</td>
                  <td>OFI122-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SORIA MEDINA ROSS MARLENY</td>
                  <td>SORIA MEDINA ROSS MARLENY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 07:00 - 09:15 / 212-49<br>
          Jueves 10:45 - 13:00 / 212-49
        </td>
                  <td>
          Martes 16:00 - 18:15 / 212-49<br>
          Jueves 16:00 - 18:15 / 212-49
        </td>
                </tr>
              </table>
  </div>
      </div>
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Práctica Profesional I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI123-I8</td>
                  <td>OFI123-I9</td>
                  <td>OFI123-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ARROYO DURAN LUIS</td>
                  <td>ARROYO DURAN LUIS</td>
                  <td>ROJAS RALDES PATRICIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 18:15 - 22:45 / 212-14<br>
          Jueves 18:15 - 20:30 / 212-13
        </td>
                  <td>
          Miércoles 07:00 - 11:30 / 212-15<br>
          Viernes 07:00 - 09:15 / 212-15
        </td>
                  <td>
          Martes 11:30 - 13:00 / 212-14<br>
          Miércoles 07:00 - 12:15
        </td>
                </tr>
              </table>
  </div>
      </div>

      <div class="Horario">
  <h2>2do Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="2">Lunes</th><th colspan="1">Martes</th><th colspan="3">Miércoles</th><th colspan="2">Jueves</th><th colspan="2">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
                <tr><td style="color: darkblue;">07:00</td><td style="color: darkblue;">07:45</td><td rowspan="3" style="background-color: skyblue;" style="background-color: skyblue;">MAT311<br>OF</td><td rowspan="3" style="background-color: lightseagreen;">OFI122<br>I7</td><td rowspan="3" style="background-color: orange;">OFI111<br>OF</td><td rowspan="6">OFI123<br>I9</td><td rowspan="7">OFI123<br>OF</td><td></td><td rowspan="3" style="background-color: orange;">OFI111<br>OF</td><td></td><td rowspan="3" style="background-color: skyblue;">MAT311<br>OF</td><td rowspan="2">OFI123<br>I9</td><td></td></tr>
                <tr><td style="color: darkblue;">07:45</td><td style="color: darkblue;">08:30</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">08:30</td><td style="color: darkblue;">09:15</td><td></td><td></td><td></td><td  rowspan="3" style="background-color: orange;">OFI111<br>I7</td></tr>
                <tr><td style="color: darkblue;">09:15</td><td style="color: darkblue;">10:00</td><td rowspan="2" style="background-color: yellow;">LEN324<br>OF</td><td rowspan="4" style="background-color: orange;">OFI111<br>I7</td><td rowspan="2" style="background-color: orange;">OFI111<br>I6</td><td></td><td rowspan="2" style="background-color: orange;">OFI111<br>I6</td><td rowspan="2"  style="background-color: green;">LEN323<br>OF</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">10:00</td><td style="color: darkblue;">10:45</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">10:45</td><td style="color: darkblue;">11:30</td><td rowspan="2"  style="background-color: green;">LEN323<br>OF</td><td></td><td></td><td rowspan="3" style="background-color: lightseagreen;">OFI122<br>I7</td><td></td><td></td><td></td><td rowspan="2" style="background-color: yellow;">LEN324<br>OF</td></tr>
                <tr><td style="color: darkblue;">11:30</td><td style="color: darkblue;">12:15</td><td rowspan="2">OFI123<br>OF</td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">12:15</td><td style="color: darkblue;">13:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">13:00</td><td style="color: darkblue;">13:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">13:45</td><td style="color: darkblue;">14:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">14:30</td><td style="color: darkblue;">15:15</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">15:15</td><td style="color: darkblue;">16:00</td><td></td><td></td><td></td><td rowspan="2" style="background-color: green;">LEN323<br>I7</td><td></td><td></td><td></td><td></td><td rowspan="2" style="background-color: yellow;">LEN324<br>I6</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:00</td><td style="color: darkblue;">16:45</td><td rowspan="2" style="background-color: skyblue;">MAT311<br>I7</td><td></td><td rowspan="3" style="background-color: lightseagreen;" style="background-color: lightseagreen;">OFI122<br>I8</td><td></td><td></td><td rowspan="3" style="background-color: lightseagreen;">OFI122<br>I8</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:45</td><td style="color: darkblue;">17:30</td><td rowspan="2" style="background-color: yellow;">LEN324<br>I6</td><td rowspan="3" style="background-color: orange;">OFI111<br>I8</td><td></td><td></td><td></td><td></td><td rowspan="2" style="background-color: green;">LEN323<br>I7</td><td></td></tr>
                <tr><td style="color: darkblue;">17:30</td><td style="color: darkblue;">18:15</td><td></td><td></td><td></td><td></td><td rowspan="2" style="background-color: skyblue;">MAT311<br>I7</td><td></td></tr>
                <tr><td style="color: darkblue;">18:15</td><td style="color: darkblue;">19:00</td><td rowspan="2" style="background-color: orange;">OFI111<br>I8</td><td></td><td rowspan="6">OFI123<br>I8</td><td rowspan="2" style="background-color: yellow;">LEN324<br>I9</td><td rowspan="2" style="background-color: skyblue;">MAT311<br>I7</td><td rowspan="3">OFI123<br>I8</td><td rowspan="2"  style="background-color: green;">LEN323<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:00</td><td style="color: darkblue;">19:45</td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:45</td><td style="color: darkblue;">20:30</td><td rowspan="2"  style="background-color: yellow;">LEN324<br>I9</td><td rowspan="3" style="background-color: skyblue;">MAT311<br>I8</td><td rowspan="2"  style="background-color: green;">LEN323<br>I8</td><td></td><td></td><td></td><td rowspan="3" style="background-color: skyblue;">MAT311<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">20:30</td><td style="color: darkblue;">21:15</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">21:15</td><td style="color: darkblue;">22:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">22:00</td><td style="color: darkblue;">22:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      
    </tbody>
  </table>
</div>
      </div>
      <div class="tab-pane">
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Organización de Oficina</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP221-I7</td>
                  <td>EMP221-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ARDUZ VARGAS YENNY TERESA</td>
                  <td>ALLERDING VACA DORIS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Sábado 07:00 - 10:45 / 212-16</td>
                  <td>Lunes 18:15 - 19:45 / 212-16<br>Viernes 18:15 - 20:30 / 212-11</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Programación</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF121-I6</td>
                  <td>INF121-I7</td>
                  <td>INF121-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SORIA MEDINA ROSS MARLENY</td>
                  <td>LOPEZ WINNIPEG GLORIA SILVIA</td>
                  <td>LOPEZ WINNIPEG MARIO MILTON</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Martes 18:15 - 20:30 / 212-52<br>Jueves 18:15 - 20:30 / 212-52</td>
                  <td>Lunes 19:00 - 21:15 / 212-50<br>Miércoles 12:15 - 14:30 / 212-52</td>
                  <td>Lunes 11:30 - 13:00 / 212-50<br>Miércoles 11:30 - 13:00 / 212-50<br>Viernes 11:30 - 13:00 / 212-50</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="materia">
       <h3 onclick="toggleDetalles(this)">Gráfico por Computadora I</h3>
       <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF132-I9</td>
                  <td>INF132-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ROJAS RALDES PATRICIA</td>
                  <td>ROJAS RALDES PATRICIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Martes 18:15 - 21:15 / 212-50<br>Jueves 18:15 - 19:45 / 212-50</td>
                  <td>Martes 08:30 - 10:45 / 212-50<br>Jueves 09:15 - 11:30 / 212-50</td>
                </tr>
              </table>
       </div>
      </div>
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Inglés Conversacional</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>LEN335-I8</td>
                  <td>LEN335-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>PIZARRO FRANCO CANDELARIA</td>
                  <td>PIZARRO FRANCO CANDELARIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Sábado 07:00 - 10:00 / 212-14</td>
                  <td>Lunes 14:30 - 16:00 / 212-13<br>Jueves 14:30 - 16:00 / 212-14</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Álgebra</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>MAT312-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ARTEAGA AGUILERA LOSMAR</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Martes 11:30 - 13:45 / 212-01<br>Jueves 11:30 - 13:45 / 212-01</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Cálculo II</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>MAT323-I7</td>
                  <td>MAT323-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GUTIERREZ TITO ROMAN</td>
                  <td>VARGAS ALBA HERIBERTO</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Martes 16:00 - 18:15 / 212-16<br>Jueves 16:00 - 18:15 / 212-16</td>
                  <td>Martes 18:15 - 20:30 / 212-16<br>Jueves 18:15 - 20:30 / 212-16</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="materia">
        <h3 onclick="toggleDetalles(this)">Productos de Oficina II</h3>
        <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI134-I8</td>
                  <td>OFI134-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>LOPEZ WINNIPEG GLORIA SILVIA / ARTEAGA AGUILERA LOSMAR AUGUSTO</td>
                  <td>RIBERA ROBLES MARÍA DEL CARMEN</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>Miércoles 19:00 - 22:45 / 212-52<br>Viernes 20:30 - 22:45 / 212-52</td>
                  <td>Miércoles 07:00 - 11:30 / 212-50</td>
                </tr>
              </table>
        </div>
      </div>
      <div class="Horario">
  <h2>3er Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="2">Lunes</th><th colspan="3">Martes</th><th colspan="1">Miércoles</th><th colspan="3">Jueves</th><th colspan="1">Viernes</th><th colspan="2">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
                <tr><td style="color: darkblue;">07:00</td><td style="color: darkblue;">07:45</td><td></td><td></td><td></td><td></td><td></td><td rowspan="6" style="background-color: yellow;">OFI134<br>OF</td><td></td><td></td><td></td><td></td><td rowspan="5" style="background-color: lightslategrey;">EMP221<br>I7</td><td rowspan="4" style="background-color: skyblue;">LEN335<br>I8</td></tr>
                <tr><td style="color: darkblue;">07:45</td><td style="color: darkblue;">08:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">08:30</td><td style="color: darkblue;">09:15</td><td></td><td></td><td rowspan="2" style="background-color: green;">INF132<br>OF</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">09:15</td><td style="color: darkblue;">10:00</td><td></td><td></td><td></td><td></td><td rowspan="2" style="background-color: green;">INF132<br>OF</td><td><td></td></td><td></tr>
                <tr><td style="color: darkblue;">10:00</td><td style="color: darkblue;">10:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">10:45</td><td style="color: darkblue;">11:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">11:30</td><td style="color: darkblue;">12:15</td><td rowspan="2" style="background-color: orange;">INF121<br>I8</td><td></td><td rowspan="2" style="background-color: lightseagreen;">MAT312<br>OF</td><td></td><td></td><td></td><td rowspan="2" style="background-color: orange;">INF121<br>I8</td><td rowspan="2" style="background-color: lightseagreen;">MAT312<br>OF</td><td></td><td rowspan="2" style="background-color: orange;">INF121<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">12:15</td><td style="color: darkblue;">13:00</td><td></td><td></td><td></td><td rowspan="3" style="background-color: orange;">INF121<br>I7</td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">13:00</td><td style="color: darkblue;">13:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">13:45</td><td style="color: darkblue;">14:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">14:30</td><td style="color: darkblue;">15:15</td><td rowspan="2" style="background-color: skyblue;">LEN335<br>OF</td><td></td><td></td><td></td><td></td><td rowspan="2" style="background-color: skyblue;">LEN335<br>OF</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">15:15</td><td style="color: darkblue;">16:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:00</td><td style="color: darkblue;">16:45</td><td></td><td></td><td rowspan="3">MAT323<br>I7</td><td></td><td></td><td></td><td rowspan="3">MAT323<br>I7</td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">16:45</td><td style="color: darkblue;">17:30</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">17:30</td><td style="color: darkblue;">18:15</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">18:15</td><td style="color: darkblue;">19:00</td><td rowspan="2" style="background-color: lightslategrey;">EMP221<br>I8</td><td></td><td rowspan="3" style="background-color: orange;">INF121<br>I6</td><td rowspan="4" style="background-color: green;">INF132<br>I9</td><td rowspan="3">MAT323<br>I8</td><td></td><td rowspan="3" style="background-color: orange;">INF121<br>I6</td><td rowspan="2" style="background-color: green;">INF132<br>I9</td><td rowspan="3">MAT323<br>I8</td><td rowspan="2" style="background-color: lightslategrey;">EMP221<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:00</td><td style="color: darkblue;">19:45</td><td rowspan="3" style="background-color: orange;">INF121<br>I7</td><td rowspan="5" style="background-color: yellow;">OFI134<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">19:45</td><td style="color: darkblue;">20:30</td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">20:30</td><td style="color: darkblue;">21:15</td><td></td><td></td><td></td><td></td><td></td><td></td><td rowspan="3" style="background-color: yellow;">OFI134<br>I8</td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">21:15</td><td style="color: darkblue;">22:00</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
                <tr><td style="color: darkblue;">22:00</td><td style="color: darkblue;">22:45</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>
      
    </tbody>
  </table>
</div>

    </div>
    <div class="tab-pane">
       <div class="materia">
  <h3 onclick="toggleDetalles(this)">Administración</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP234-I7</td>
                  <td>EMP234-I8</td>
                  <td>EMP234-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ANTELO QUIROGA ROLIN JESUS</td>
                  <td>ANTELO QUIROGA ROLIN JESUS</td>
                  <td>CABRERA SOLANO RUTH MARISOL</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 16:00 - 18:15 / 212-13<br>
          Miércoles 16:45 - 18:15 / 212-01
        </td>
                  <td>
          Martes 20:30 - 22:45 / 212-13<br>
          Viernes 18:15 - 19:45 / 212-03
        </td>
                  <td>
          Martes 09:15 - 11:30 / 212-04<br>
          Jueves 10:00 - 11:30 / 212-17
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Teleinformática I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR142-I7</td>
                  <td>HAR142-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VASQUEZ ESCOBAR ORLANDO</td>
                  <td>PAZ MENDOZA ROBERTO CARLOS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 13:45 - 16:00 / 212-49<br>
          Jueves 13:45 - 16:00 / 212-49
        </td>
                  <td>
          Jueves 18:15 - 22:45 / 212-51
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Sistemas Operativos I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR143-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>LOPEZ NEGRETTY MARY DUNNIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 13:45 - 16:00 / 212-49<br>
          Miércoles 13:45 - 16:00 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Soporte Técnico I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR155-I7</td>
                  <td>HAR155-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VASQUEZ ESCOBAR ORLANDO</td>
                  <td>BALCAZAR VEIZAGA EVANZ</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 16:00 - 18:15 / 212-52<br>
          Jueves 16:00 - 18:15 / 212-52
        </td>
                  <td>
          Lunes 18:15 - 20:30 / 212-29<br>
          Lunes 20:30 - 22:45 / 212-09
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Práctica Profesional II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF144-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>TAPIA FLORES LUIS PERCY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes 07:00 - 12:15 / 212-19<br>
          Miércoles 09:15 - 10:45 / 212-19
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Gráfica por Computadora II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF165-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>PAZ MENDOZA ROBERTO CARLOS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 07:00 - 09:15 / 212-49<br>
          Jueves 07:00 - 09:15 / 212-51
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Productos de Oficina III</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI145-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>JUSTINIANO ROCA RONALD</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes 19:00 - 20:30 / 212-49<br>
          Viernes 19:45 - 22:45 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">MODALIDAD GRADUACIÓN MEDIO</h3>
  <div class="detalles">
    <table>
                <tr><td><strong>Docente:</strong></td><td>RIBERA ROBLES MARIA DEL CARMEN</td></tr>
              </table>
  </div>
</div>
<div class="Horario">
  <h2>4to Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="1">Lunes</th><th colspan="1">Martes</th><th colspan="1">Miércoles</th><th colspan="1">Jueves</th><th colspan="1">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
                <tr>	<td style="color: darkblue;">07:00	</td><td style="color: darkblue;">07:45	</td>	<td rowspan="2" style="background-color: yellow;">INF144<br>OF</td>	<td rowspan="3">INF165<br>OF</td>	<td></td>	<td rowspan="3">INF165<br>OF</td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">07:45	</td><td style="color: darkblue;">08:30	</td>			<td></td>		<td></td>	<td></td>
<tr>	<td style="color: darkblue;">08:30	</td><td style="color: darkblue;">09:15	</td>			<td></td>		<td></td>	<td></td><td></td>
<tr>	<td style="color: darkblue;">09:15	</td><td style="color: darkblue;">10:00	</td>		<td rowspan="3" style="background-color: orange;">EMP234<br>OF</td>	<td rowspan="2" style="background-color: yellow;">INF144<br>OF</td>	<td></td>	<td></td>	<td></td><td></td>
<tr>	<td style="color: darkblue;">10:00	</td><td style="color: darkblue;">10:45	</td>			<td rowspan="2" style="background-color: yellow;">INF144<br>OF</td>	<td rowspan="2" style="background-color: orange;">EMP234<br>OF</td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">10:45	</td><td style="color: darkblue;">11:30	</td>			<td></td>		<td></td>	<td></td>
<tr>	<td style="color: darkblue;">11:30	</td><td style="color: darkblue;">12:15	</td>		<td></td>	<td></td>	<td></td>	<td></td>	<td></td><td></td>
<tr>	<td style="color: darkblue;">12:15	</td><td style="color: darkblue;">13:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">13:00	</td><td style="color: darkblue;">13:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">13:45	</td><td style="color: darkblue;">14:30	</td>	<td rowspan="3" style="background-color: green;">HAR143<br>OF</td>	<td rowspan="3">HAR142<br>I7</td>	<td rowspan="3" style="background-color: green;">HAR143<br>OF</td>	<td rowspan="3">HAR142<br>I7</td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">14:30	</td><td style="color: darkblue;">15:15	</td>					<td></td>	<td></td>
<tr>	<td style="color: darkblue;">15:15	</td><td style="color: darkblue;">16:00	</td>					<td></td>	<td></td>
<tr>	<td style="color: darkblue;">16:00	</td><td style="color: darkblue;">16:45	</td>	<td rowspan="3" style="background-color: orange;">EMP234<br>I7</td>	<td rowspan="3" style="background-color: skyblue;">HAR155<br>I7</td>	<td></td>	<td rowspan="3" style="background-color: skyblue;">HAR155<br>I7</td>	<td></td>	<td></td>
<tr>	<td style="color: darkblue;">16:45	</td><td style="color: darkblue;">17:30	</td>			<td rowspan="3" style="background-color: orange;">EMP234<br>I7</td>		<td></td>	<td></td>
<tr>	<td style="color: darkblue;">17:30	</td><td style="color: darkblue;">18:15	</td>					<td></td>	<td></td>
<tr>	<td style="color: darkblue;">18:15	</td><td style="color: darkblue;">19:00	</td>	<td rowspan="6" style="background-color: skyblue;">HAR155<br>I8</td>	<td></td>		<td rowspan="6">HAR142<br>I8</td>	<td rowspan="2" style="background-color: orange;">EMP234<br>I8</td>	<td></td>
<tr>	<td style="color: darkblue;">19:00	</td><td style="color: darkblue;">19:45	</td>		<td rowspan="2" style="background-color: rgb(29, 107, 170);">OFI145<br>I8</td>	<td></td>			<td></td>
<tr>	<td style="color: darkblue;">19:45	</td><td style="color: darkblue;">20:30	</td>			<td></td>		<td rowspan="4" style="background-color: rgb(29, 107, 170);">OFI145<br>I8</td>	<td></td>
<tr>	<td style="color: darkblue;">20:30	</td><td style="color: darkblue;">21:15	</td>			<td rowspan="3" style="background-color: orange;">EMP234<br>I8</td><td></td><td></td>			
<tr>	<td style="color: darkblue;">21:15	</td><td style="color: darkblue;">22:00	</td>			<td></td>			<td></td>
<tr>	<td style="color: darkblue;">22:00	</td><td style="color: darkblue;">22:45	</td>			<td></td>			<td></td>


    </tbody>
  </table>
</div>
    </div>
      <div class="tab-pane">
        <div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Contabilidad General</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP233-I7</td>
                  <td>EMP233-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GALVIS MENDEZ MONICA</td>
                  <td>VALVERDE TERAN LOLA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 15:15 - 16:45 / 212-14<br>
          Mié: 15:15 - 17:30 / 212-13
        </td>
                  <td>
          Lun: 18:15 - 22:45 / 212-06
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Paquetes Contables</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP257-I9</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VALVERDE TERAN LOLA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Vie: 09:15 - 13:00 / 212-51
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Teleinformática II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR154-I8</td>
                  <td>HAR154-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>CABALLERO RUA MAURICIO CHRISTIAN</td>
                  <td>GONZALES SANDOVAL JORGE ANTONIO</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 18:15 - 20:30 / 212-52<br>
          Vie: 18:15 - 20:30 / 212-50
        </td>
                  <td>
          Lun: 07:00 - 09:15 / 212-52<br>
          Vie: 07:00 - 09:15 / 212-52
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Sistema Operativo II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR156-I8</td>
                  <td>HAR156-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>LOPEZ NEGRETTY MARY DUNNIA</td>
                  <td>LOPEZ NEGRETTY MARY DUNNIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 09:15 - 11:30 / 212-50<br>
          Mar: 10:00 - 12:15 / 212-49
        </td>
                  <td>
          Mar: 12:15 - 14:30 / 212-52<br>
          Jue: 12:15 - 14:30 / 212-52
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Soporte Técnico II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR157-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>FLORES GUZMAN VALENTIN VICTOR</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 18:15 - 20:30 / 212-17<br>
          Jue: 16:00 - 18:15 / 212-50
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia"> 
  <h3 onclick="toggleDetalles(this)">Base de Datos I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF143-I7</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SORIA MEDINA ROSS MARLENY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 16:45 - 18:15 / 212-52<br>
          Mié: 07:00 - 10:00 / 212-52
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="Horario">
  <h2>5to Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="2">Lunes</th><th colspan="1">Martes</th><th colspan="1">Miércoles</th><th colspan="1">Jueves</th><th colspan="1">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
<tr>	<td style="color: darkblue;">07:00	</td><td style="color: darkblue;">07:45	</td>	<td rowspan="3" style="background-color: yellow;">HAR154<br>OF</td>	<td></td>	<td></td>	<td rowspan="4" style="background-color: skyblue;">INF143<br>I7</td>	<td></td>	<td rowspan="3" style="background-color: yellow;">HAR154<br>OF</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">07:45	</td><td style="color: darkblue;">08:30	</td>		<td></td>	<td></td>		<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">08:30	</td><td style="color: darkblue;">09:15	</td>		<td></td>	<td></td>		<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">09:15	</td><td style="color: darkblue;">10:00	</td>	<td rowspan="3" style="background-color: green;">HAR156<br>I8</td>	<td></td>	<td></td>		<td></td>	<td rowspan="5">EMP257<br>I9</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:00	</td><td style="color: darkblue;">10:45	</td>		<td></td>	<td rowspan="3" style="background-color: green;">HAR156<br>I8</td>	<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:45	</td><td style="color: darkblue;">11:30	</td>		<td></td>		<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">11:30	</td><td style="color: darkblue;">12:15	</td>	<td></td>	<td></td>		<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">12:15	</td><td style="color: darkblue;">13:00	</td>	<td></td>	<td></td>	<td rowspan="3" style="background-color: green;">HAR156<br>OF</td>	<td></td>	<td rowspan="3" style="background-color: green;">HAR156<br>OF</td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:00	</td><td style="color: darkblue;">13:45	</td>	<td></td>	<td></td>		<td></td>		<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:45	</td><td style="color: darkblue;">14:30	</td>	<td></td>	<td></td>		<td></td>		<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">14:30	</td><td style="color: darkblue;">15:15	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">15:15	</td><td style="color: darkblue;">16:00	</td>	<td rowspan="2" style="background-color: orange;">EMP233<br>I7</td>	<td></td>	<td></td>	<td rowspan="3" style="background-color: orange;">EMP233<br>I7</td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:00	</td><td style="color: darkblue;">16:45	</td>		<td></td>	<td></td>		<td rowspan="2" style="background-color: gray;">HAR157<br>OF</td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:45	</td><td style="color: darkblue;">17:30	</td>	<td rowspan="2" style="background-color: skyblue;">INF143<br>I7</td>	<td></td>	<td></td>			<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">17:30	</td><td style="color: darkblue;">18:15	</td>		<td></td>	<td></td>	<td></td>		<td></td>	<td></td><td></td>	</tr>
<tr>	<td style="color: darkblue;">18:15	</td><td style="color: darkblue;">19:00	</td>	<td rowspan="6" style="background-color: orange;">EMP233<br>OF</td>	<td rowspan="3" style="background-color: yellow;">HAR154<br>I8</td>	<td rowspan="6" style="background-color: gray;">HAR157<br>OF</td>	<td></td>	<td></td>	<td rowspan="3" style="background-color: yellow;">HAR154<br>I8</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:00	</td><td style="color: darkblue;">19:45	</td>				<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:45	</td><td style="color: darkblue;">20:30	</td>				<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">20:30	</td><td style="color: darkblue;">21:15	</td>		<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">21:15	</td><td style="color: darkblue;">22:00	</td>		<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">22:00	</td><td style="color: darkblue;">22:45	</td>		<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>

    </tbody>
  </table>
</div>
    </div>
    <div class="tab-pane">
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Auditoria</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP245-I8</td>
                  <td>EMP245-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>OROSCO GOMEZ RUBEN</td>
                  <td>OROSCO GOMEZ RUBEN</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 19:45 - 21:15 / 212-03<br>
          Sáb: 08:30 - 10:45 / 212-13
        </td>
                  <td>
          Mar: 07:00 - 09:15 / 212-14<br>
          Jue: 07:00 - 08:30 / 212-13
        </td>
                </tr>
              </table>
  </div>
      </div>
    <div class="materia">
  <h3 onclick="toggleDetalles(this)">Base de Datos II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF166-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SORIA MEDINA ROSS MARLENY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 09:15 - 12:15 / 212-52<br>
          Jue: 08:30 - 10:00 / 212-52
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Estadísticas</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
        <tdstyle="background-color: orange;" >MAT354-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SAUCEDO HURTADO JUAN FERNANDO</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 20:30 - 22:45 / 212-11<br>
          Vie: 18:15 - 20:30 / 212-16
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Sistemas de Información</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF141-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GUTHRIE PACHECO MIGUEL ANGEL</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 12:15 - 13:45 / 212-49<br>
          Mar: 12:15 - 13:45 / 212-49<br>
          Vie: 07:00 - 08:30 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Temas Especiales I</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF164-I8</td>
                  <td>SOF164-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VACA PINTO CESPEDES ROBERTO CARLOS</td>
                  <td>VACA PINTO CESPEDES ROBERTO CARLOS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 18:15 - 19:45 / 212-49<br>
          Mié: 18:15 - 20:30 / 212-49
        </td>
                  <td>
          Mar: 13:45 - 16:00 / 212-50<br>
          Jue: 14:30 - 16:00 / 212-50
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Práctica Profesional III</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF166-I7</td>
                  <td>SOF166-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GALVIS MENDEZ MONICA</td>
                  <td>TAPIA FLORES LUIS PERCY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 14:30 - 16:45 / 212-30<br>
          Jue: 14:30 - 16:45 / 212-30<br>
          Vie: 14:30 - 16:45 / 212-30
        </td>
                  <td>
          Sáb: 10:45 - 17:30 / 212-52
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">MODALIDAD GRADUACIÓN TÉCNICO</h3>
  <div class="detalles">
    <table>
                <tr><td><strong>Docente:</strong></td><td>Carlos Díaz</td></tr>
                <tr><td><strong>Horario:</strong></td><td>Viernes, 09:00 - 11:00</td></tr>
                <tr><td><strong>Aula:</strong></td><td>Lab 1</td></tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">MODALIDAD GRADUACIÓN DIRECTO</h3>
  <div class="detalles">
    <table>
                <tr><td><strong>Docente:</strong></td><td>Carlos Díaz</td></tr>
                <tr><td><strong>Horario:</strong></td><td>Viernes, 09:00 - 11:00</td></tr>
                <tr><td><strong>Aula:</strong></td><td>Lab 1</td></tr>
              </table>
  </div>
</div>
<div class="Horario">
  <h2>6to Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="1">Lunes</th><th colspan="2">Martes</th><th colspan="1">Miércoles</th><th colspan="2">Jueves</th><th colspan="1">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->

<tr>	<td style="color: darkblue;">07:00	</td><td style="color: darkblue;">07:45	</td>		<td rowspan="3" style="background-color: yellow;" >EMP245<br>OF</td>	<td></td>	<td></td>	<td rowspan="2" style="background-color: yellow;" >EMP245<br>OF</td>	<td></td>	<td rowspan="3" style="background-color: skyblue;">SOF141<br>OF</td>	<td></td><td></td></tr>
<tr>	<td style="color: darkblue;">07:45	</td><td style="color: darkblue;">08:30	</td>			<td></td>	<td></td>		<td></td>		<td></td><td></td></tr>
<tr>	<td style="color: darkblue;">08:30	</td><td style="color: darkblue;">09:15	</td>			<td></td>	<td></td>	<td rowspan="3" style="background-color: lightseagreen;">INF166<br>OF</td>	<td></td>		<td rowspan="3" style="background-color: yellow;" >EMP245<br>I8</td><td></td> </tr>
<tr>	<td style="color: darkblue;">09:15	</td><td style="color: darkblue;">10:00	</td>	<td rowspan="4" style="background-color: lightseagreen;">INF166<br>OF</td>	<td></td>	<td></td>	<td></td>		<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">10:00	</td><td style="color: darkblue;">10:45	</td>		<td></td>	<td></td>	<td></td>		<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">10:45	</td><td style="color: darkblue;">11:30	</td>		<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td rowspan="9" style="background-color: green;">SOF166<br>OF</td>	</tr>
<tr>	<td style="color: darkblue;">11:30	</td><td style="color: darkblue;">12:15	</td>		<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">12:15	</td><td style="color: darkblue;">13:00	</td>	<td rowspan="2" style="background-color: skyblue;">SOF141<br>OF</td>	<td rowspan="2" style="background-color: skyblue;">SOF141<br>OF</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">13:00	</td><td style="color: darkblue;">13:45	</td>			<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">13:45	</td><td style="color: darkblue;">14:30	</td>	<td></td>	<td rowspan="3">SOF164<br>OF</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">14:30	</td><td style="color: darkblue;">15:15	</td>	<td></td>		<td rowspan="3" style="background-color: green;">SOF166<br>I7</td>	<td></td>	<td rowspan="2">SOF164<br>OF</td>	<td rowspan="3" style="background-color: green;">SOF166<br>I7</td>	<td rowspan="3" style="background-color: green;">SOF166<br>I7</td>		</tr>
<tr>	<td style="color: darkblue;">15:15	</td><td style="color: darkblue;">16:00	</td>	<td></td>			<td></td>					</tr>
<tr>	<td style="color: darkblue;">16:00	</td><td style="color: darkblue;">16:45	</td>	<td></td>	<td></td>		<td></td>	<td></td>				</tr>
<tr>	<td style="color: darkblue;">16:45	</td><td style="color: darkblue;">17:30	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		</tr>
<tr>	<td style="color: darkblue;">17:30	</td><td style="color: darkblue;">18:15	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">18:15	</td><td style="color: darkblue;">19:00	</td>	<td rowspan="2">SOF164<br>I8</td>	<td></td>	<td></td>	<td rowspan="3">SOF164<br>I8</td>	<td></td>	<td></td>	<td rowspan="3"style="background-color: orange;" >MAT354<br>I8</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:00	</td><td style="color: darkblue;">19:45	</td>		<td></td>	<td></td>		<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:45	</td><td style="color: darkblue;">20:30	</td>	<td rowspan="2" style="background-color: yellow;" >EMP245<br>I8</td>	<td></td>	<td></td>		<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">20:30	</td><td style="color: darkblue;">21:15	</td>		<td rowspan="3"style="background-color: orange;" >MAT354<br>I8</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">21:15	</td><td style="color: darkblue;">22:00	</td>	<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">22:00	</td><td style="color: darkblue;">22:45	</td>	<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>

    </tbody>
  </table>
</div>
    </div>
      <div class="tab-pane">
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Derecho Informático</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP266-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>
          JUSTINIANO FLORES CARMEN LILIAN</td>
                </tr> 
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 20:30 - 22:00 / 212-29<br>
          Jue: 19:45 - 22:00 / 212-14
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Gestión de Recursos Humanos</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
        <tdstyle="background-color: yellow;" >MAT354-I8</td>
        <tdstyle="background-color: yellow;" >MAT354-OF</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>CABRERA SOLANO RUTH MARISOL</td>
                  <td>CABRERA SOLANO RUTH MARISOL</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 18:15 - 22:00 / 212-20
        </td>
                  <td>
          Mié: 08:30 - 12:15 / 212-05
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Gestión de Riesgos</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>EMP279-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SELAYA GARVIZU IVAN VLADISHLAV</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lun: 16:45 - 18:15 / 212-08<br>
          Mié: 16:45 - 19:00 / 212-14
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Seguridad Informática</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>HAR178-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>UBALDO PEREZ</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mié: 20:30 - 22:45 / 212-03<br>
          Vie: 13:00 - 15:15 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Investigación Operativa</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>MAT375-I7</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VACA PINTO CESPEDES ROBERTO CARLOS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 18:15 - 19:45 / 212-01<br>
          Jue: 18:15 - 20:30 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Administración Informática</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF163-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>TAPIA FLORES LUIS PERCY</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Mar: 16:00 - 18:15 / 212-11<br>
          Jue: 16:00 - 18:15 / 212-13
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="Horario">
  <h2>7mo Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="1">Lunes</th><th colspan="2">Martes</th><th colspan="1">Miércoles</th><th colspan="2">Jueves</th><th colspan="1">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
<tr>	<td style="color: darkblue;">07:00	</td><td style="color: darkblue;">07:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">07:45	</td><td style="color: darkblue;">08:30	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">08:30	</td><td style="color: darkblue;">09:15	</td>	<td></td>	<td></td>	<td></td>	<td rowspan="5"style="background-color: yellow;" >MAT354<br>OF</td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">09:15	</td><td style="color: darkblue;">10:00	</td>	<td></td>		<td></td><td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:00	</td><td style="color: darkblue;">10:45	</td>	<td></td>		<td></td><td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:45	</td><td style="color: darkblue;">11:30	</td>	<td></td>	<td></td> 	<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">11:30	</td><td style="color: darkblue;">12:15	</td>	<td></td>	<td></td>	<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">12:15	</td><td style="color: darkblue;">13:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:00	</td><td style="color: darkblue;">13:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td rowspan="3"style="background-color: skyblue;" >HAR178<br>I8</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:45	</td><td style="color: darkblue;">14:30	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">14:30	</td><td style="color: darkblue;">15:15	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">15:15	</td><td style="color: darkblue;">16:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:00	</td><td style="color: darkblue;">16:45	</td>	<td></td>	<td rowspan="3"style="background-color: green;" >MAT354<br>I8</td>	<td></td>	<td></td>	<td rowspan="3"style="background-color: green;" >MAT354<br>I8</td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:45	</td><td style="color: darkblue;">17:30	</td>	<td rowspan="2"style="background-color: orange;" >MAT354<br>I8</td>		<td></td>	<td rowspan="3"style="background-color: orange;" >MAT354<br>I8</td>		<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">17:30	</td><td style="color: darkblue;">18:15	</td>			<td></td>			<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">18:15	</td><td style="color: darkblue;">19:00	</td>	<td></td>	<td rowspan="5"style="background-color: yellow;" >MAT354<br>OF</td>	<td rowspan="2">MAT375<br>I7</td>		<td></td>	<td rowspan="3">MAT375<br>I7</td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:00	</td><td style="color: darkblue;">19:45	</td>	<td></td>			<td></td>	<td></td>		<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:45	</td><td style="color: darkblue;">20:30	</td>	<td></td>		<td></td>	<td></td>	<td rowspan="3"style="background-color: lightseagreen;" >MAT354<br>I8</td>		<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">20:30	</td><td style="color: darkblue;">21:15	</td>	<td rowspan="2"style="background-color: lightseagreen;" >MAT354<br>I8</td>		<td></td>	<td rowspan="3"style="background-color: skyblue;" >HAR178<br>I8</td>		<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">21:15	</td><td style="color: darkblue;">22:00	</td>			<td></td>			<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">22:00	</td><td style="color: darkblue;">22:45	</td>	<td></td>	<td></td>	<td></td>		<td></td>	<td></td>	<td></td>	<td></td>	</tr>

    </tbody>
  </table>
</div>
    </div>
      <div class="tab-pane">
      <div class="materia">
  <h3 onclick="toggleDetalles(this)">Gestión de Sitios Web</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>INF187-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>VACA PINTO CESPEDES ROBERTO CARLOS</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes: 16:00 - 18:15 / 212-49<br>
          Miércoles: 16:45 - 18:15 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Gestión de Proyectos</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>OFI186-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>ROJAS RALDES PATRICIA</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Martes: 07:00 - 08:30 / 212-50<br>
          Jueves: 07:00 - 09:15 / 212-50
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Tratamiento de la Información</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF152-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>RIBERA ROBLES MARIA DEL CARMEN</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Lunes: 19:45 - 22:00 / 212-49<br>
          Miércoles: 20:30 - 22:00 / 212-49
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Análisis de Datos</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF187-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>GUTHRIE PACHECO MIGUEL ANGEL</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Miércoles: 12:15 - 13:45 / 212-49<br>
          Jueves: 12:15 - 14:30 / 212-50
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">Temas Especiales II</h3>
  <div class="detalles">
              <table class="tabla-detalles">
                <tr>
                  <th>GRUPO</th>
                  <td>SOF188-I8</td>
                </tr>
                <tr>
                  <th>DOCENTE</th>
                  <td>SELAYA GARVIZU IVAN VLADISHLAV</td>
                </tr>
                <tr>
                  <th>HORARIO / AULA</th>
                  <td>
          Miércoles: 07:00 - 08:30 / 212-50<br>
          Viernes: 07:00 - 09:15 / 212-50
        </td>
                </tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">MODALIDAD GRADUACIÓN LICENCIATURA</h3>
  <div class="detalles">
    <table>
                <tr><td><strong>Docente:</strong></td><td>Carlos Díaz</td></tr>
                <tr><td><strong>Horario:</strong></td><td>Viernes, 09:00 - 11:00</td></tr>
                <tr><td><strong>Aula:</strong></td><td>Lab 1</td></tr>
              </table>
  </div>
</div>
<div class="materia">
  <h3 onclick="toggleDetalles(this)">MODALIDAD GRADUACIÓN DIRECTO</h3>
  <div class="detalles">
    <table>
                <tr><td><strong>Docente:</strong></td><td>Carlos Díaz</td></tr>
                <tr><td><strong>Horario:</strong></td><td>Viernes, 09:00 - 11:00</td></tr>
                <tr><td><strong>Aula:</strong></td><td>Lab 1</td></tr>
              </table>
  </div>
</div>
<div class="Horario">
  <h2>8vo Semestre</h2>
  <table border="1" class="horario-table">
    <thead>
                <tr>
                  <th>Hr In</th><th>Hr Fin</th><th colspan="1">Lunes</th><th colspan="1">Martes</th><th colspan="1">Miércoles</th><th colspan="1">Jueves</th><th colspan="1">Viernes</th><th colspan="1">Sábado</th>
                </tr>
       </thead>
    <tbody>
      <!-- Cada fila de 45min desde 07:00 hasta 22:45 -->
<tr>	<td style="color: darkblue;">07:00	</td><td style="color: darkblue;">07:45	</td>	<td></td>	<td rowspan="2"style="background-color: skyblue;" >OFI186<br>I8</td>	<td rowspan="3">SOF188<br>I8</td>	<td rowspan="3"style="background-color: skyblue;" >OFI186<br>I8</td>	<td rowspan="4">SOF188<br>I8</td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">07:45	</td><td style="color: darkblue;">08:30	</td>	<td></td><td></td>	</tr>
<tr>	<td style="color: darkblue;">08:30	</td><td style="color: darkblue;">09:15	</td>	<td></td><td></td><td></td>	</tr>
<tr>	<td style="color: darkblue;">09:15	</td><td style="color: darkblue;">10:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>		<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:00	</td><td style="color: darkblue;">10:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">10:45	</td><td style="color: darkblue;">11:30	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">11:30	</td><td style="color: darkblue;">12:15	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">12:15	</td><td style="color: darkblue;">13:00	</td>	<td></td>	<td></td>	<td rowspan="2"style="background-color: yellow;" >SOF187<br>I8</td>	<td rowspan="3"style="background-color: yellow;" >SOF187<br>I8</td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:00	</td><td style="color: darkblue;">13:45	</td>	<td></td>	<td></td>			<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">13:45	</td><td style="color: darkblue;">14:30	</td>	<td></td>	<td></td>	<td></td>		<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">14:30	</td><td style="color: darkblue;">15:15	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">15:15	</td><td style="color: darkblue;">16:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:00	</td><td style="color: darkblue;">16:45	</td>	<td rowspan="3"style="background-color: orange;" >INF187<br>I8</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">16:45	</td><td style="color: darkblue;">17:30	</td>		<td></td>	<td rowspan="2"style="background-color: orange;" >INF187<br>I8</td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">17:30	</td><td style="color: darkblue;">18:15	</td>		<td></td>			<td></td>	<td></td><td></td>	</tr>
<tr>	<td style="color: darkblue;">18:15	</td><td style="color: darkblue;">19:00	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:00	</td><td style="color: darkblue;">19:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">19:45	</td><td style="color: darkblue;">20:30	</td>	<td rowspan="3"style="background-color: green;" >SOF152<br>I8</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">20:30	</td><td style="color: darkblue;">21:15	</td>		<td></td>	<td rowspan="2"style="background-color: green;" >SOF152<br>I8</td>	<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">21:15	</td><td style="color: darkblue;">22:00	</td>		<td></td>		<td></td>	<td></td>	<td></td>	</tr>
<tr>	<td style="color: darkblue;">22:00	</td><td style="color: darkblue;">22:45	</td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	<td></td>	</tr>

    </tbody>
  </table>
</div>
    </div>

  </div>
</div>
<button id="toggleAuxBtn" class="aux-btn-mobile">Auxiliaturas</button>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("collapsed");
    }

    function toggleDetalles(header) {
      const detalles = header.nextElementSibling;
      detalles.style.display = detalles.style.display === "block" ? "none" : "block";
    }

    function showTab(index) {
      document.querySelectorAll(".tab-btn").forEach((btn, i) => {
        btn.classList.toggle("active", i === index);
      });
      document.querySelectorAll(".tab-pane").forEach((pane, i) => {
        pane.classList.toggle("active", i === index);
      });
    }
  </script>
  <script src="nodes.js"></script>
<script>
function toggleDetalle(item) {
  const detalle = item.querySelector('.detalle');
  const abierto = detalle.style.display === 'block';

  // Cerrar todos
  document.querySelectorAll('.aux-bar .detalle').forEach(d => d.style.display = 'none');

  // Abrir el actual si estaba cerrado
  if (!abierto) {
    detalle.style.display = 'block';
  }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("toggleAuxBtn");
  const auxBar = document.getElementById("auxBar");

  btn.addEventListener("click", () => {
    auxBar.classList.toggle("visible");
  });
});
</script>

<script>
function convertirTodasLasTablas() {
  // Solo aplica en pantallas pequeñas (vista móvil)
  if (window.innerWidth > 768) return;

  document.querySelectorAll('.tabla-detalles').forEach(tabla => {
    const filas = [...tabla.rows];
    const categorias = filas.map(fila => fila.cells[0].innerText);
    const columnas = filas[0].cells.length;

    const contenedor = document.createElement('div');
    contenedor.className = "tabla-detalle-transpuesta";
    contenedor.style.padding = "0 10px"; // padding lateral para centrado visual

    for (let col = 1; col < columnas; col++) {
      const nuevaTabla = document.createElement('table');
      nuevaTabla.className = 'mini-tabla';
      const tbody = document.createElement('tbody');

      for (let fila = 0; fila < filas.length; fila++) {
        const tr = document.createElement('tr');
        const th = document.createElement('th');
        th.textContent = categorias[fila];
        const td = document.createElement('td');
        td.innerHTML = filas[fila].cells[col].innerHTML;
        tr.appendChild(th);
        tr.appendChild(td);
        tbody.appendChild(tr);
      }

      nuevaTabla.appendChild(tbody);
      contenedor.appendChild(nuevaTabla);
    }

    // Reemplazar la tabla original por el contenedor transpuesto
    tabla.parentNode.replaceChild(contenedor, tabla);
  });
}

// Ejecutar cuando cargue el DOM
document.addEventListener('DOMContentLoaded', convertirTodasLasTablas);

// Opcional: volver a cargar si se cambia el tamaño de pantalla (ej. de escritorio a móvil)
window.addEventListener('resize', () => {
  if (window.innerWidth <= 768) {
    location.reload(); // o puedes limpiar y volver a ejecutar convertirTodasLasTablas()
  }
});
</script>
<script>
  // Alternar barra auxiliar
  function toggleAuxBar() {
    document.getElementById('auxBar').classList.toggle('collapsed');
  }

  // Alternar detalle dentro de cada <li>
  function toggleDetalle(item) {
    item.classList.toggle('active');
  }
</script>
<script>
function toggleDetalle(item) {
  const detalle = item.querySelector('.detalle');
  if (detalle) {
    detalle.style.display = (detalle.style.display === 'block') ? 'none' : 'block';
  }
}
</script>
<style>
  body {
    margin: 0;
    padding: 0;
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


  .footer-contenido {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
  }

  .footer-col {
    flex: 1 1 250px;
    margin-bottom: 1.5rem;
  }

  .footer-col h3, .footer-col h4 {
    margin-bottom: 0.8rem;
  }

  .footer-col p, .footer-col a {
    font-size: 0.9rem;
    color: white;
    text-decoration: none;
  }

  .footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.3);
    margin-top: 1.5rem;
    padding-top: 1rem;
    text-align: center;
    font-size: 0.75rem;
  }
</style>

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
