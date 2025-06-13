let gruposSeleccionados = [];

function cargarGrupos(materiasResultado) {
  const contenedor = document.getElementById("contenedor-grupos");
  contenedor.innerHTML = "";
  gruposSeleccionados = [];

  const grupos = [
{ sigla:"EMP210", grupo:"OF",nombre:"Realidad Nacional",docente:"ALLERDING VACA DORIS",Horario:"Martes      18:15   19:45   212-31   Jueves      18:15   19:45   212-07   "},
{ sigla:"EMP210 ",grupo:"I9",nombre:"Realidad Nacional",docente:"ALLERDING VACA DORIS",Horario:"Lunes       12:15   13:45   212-16   Miercoles   12:15   13:45   212-16   "},
{ sigla:"HAR111 ",grupo:"I7",nombre:"Electrónica General ",docente:"GUTIERREZ SUAREZ JOSE LIMBERG",Horario:"Martes      16:00   18:15   212-01   Jueves      16:00   18:15   212-01   "},
{ sigla:"HAR111 ",grupo:"I8",nombre:"Electrónica General ",docente:"ARCE GALVIS SANTOS DOMINGO",Horario:"Martes      19:45   22:00   212-01   Jueves      19:45   22:00   212-01   "},
{ sigla:"HAR111 ",grupo:"OF",nombre:"Electrónica General ",docente:"CARVALLO GOMEZ JHONNY VLADIMIR  ",Horario:"Martes      09:15   11:30   212-01   Jueves      09:15   11:30   212-01   "},
{ sigla:"LEN311 ",grupo:"I7",nombre:"Inglés I",docente:"ZUÑIGA RUIZ WILMA",Horario:"Lunes       13:45   15:15   212-01   Miercoles   15:15   16:45   212-01   "},
{ sigla:"LEN311 ",grupo:"I9",nombre:"Inglés I",docente:"PIZARRO FRANCO CANDELARIA ",Horario:"Sabado      11:30   14:30   212-01   "},
{ sigla:"LEN311 ",grupo:"OF",nombre:"Inglés I",docente:"BENEGAS LIJERON MARIA DEL CARMEN",Horario:"Miercoles   11:30   13:00   212-01   Viernes     11:30   13:00   212-01   "},
{ sigla:"LEN311 ",grupo:"I8",nombre:"Inglés I",docente:"PIZARRO FRANCO CANDELARIA ",Horario:"Lunes       19:45   21:45   212-51   Miercoles   19:45   21:45   212-01   "},
{ sigla:"LEN312 ",grupo:"I7",nombre:"Lenguaje I",docente:"ARDUZ VARGAS YENNY TERESA ",Horario:"Miercoles   13:45   15:15   212-50    Sabado      12:15   13:45   212-05   "},
{ sigla:"LEN312 ",grupo:"OF",nombre:"Lenguaje I",docente:"GALARZA DE EID MARIA ELIZABETH  ",Horario:"Miercoles   08:30   11:30   212-13   "},
{ sigla:"LEN312 ",grupo:"I8",nombre:"Lenguaje I",docente:"CASTRO SUAREZ SOLIA",Horario:"Lunes       21:15   22:45   212-01   Viernes     18:15   19:45   212-20   "},
{ sigla:"MAT310 ",grupo:"I9",nombre:"Matemática Básica",docente:"MARIA DEL CARMEN RIBERA ROBLES  ",Horario:"Lunes       08:30   10:00   212-06   "},
{ sigla:"MAT310 ",grupo:"I8",nombre:"Matemática Básica",docente:"GUTIERREZ SUAREZ JOSE LIMBERG",Horario:"Lunes       18:15   19:45   212-03   Miercoles   18:15   19:45   212-03   "},
{ sigla:"MAT310 ",grupo:"I7",nombre:"Matemática Básica",docente:"CASTRO CAMACHO JOSE ROBERTO",Horario:"Jueves      14:30   16:00   212-03   Martes      14:30   16:00   212-03   "},
{ sigla:"MAT310 ",grupo:"I9",nombre:"Matemática Básica",docente:"MARIA DEL CARMEN RIBERA ROBLES  ",Horario:"Lunes     08:30   10:00   212-10  Viernes     08:30   10:00   212-10   "},
{ sigla:"MAT310 ",grupo:"OF",nombre:"Matemática Básica",docente:"CASTRO CAMACHO JOSE ROBERTO",Horario:"Martes      07:00   08:30   212-06   Jueves      07:00   08:30   212-10   "},
{ sigla:"LEN323",grupo:"I7",nombre:"Inglés II ",docente:"BENEGAS LIJERON MARIA DEL CARMEN",Horario:"Miercoles  15:15   16:45   212-14  Viernes    16:45   18:15   212-14  "},
{ sigla:"LEN323",grupo:"I8",nombre:"Inglés II ",docente:"BENEGAS LIJERON MARIA DEL CARMEN",Horario:"Miercoles  19:45   21:15   212-16  Viernes    18:15   19:45   212-18  "},
{ sigla:"LEN323",grupo:"OF",nombre:"Inglés II ",docente:"PIZARRO FRANCO CANDELARIA",Horario:"Lunes      10:45   12:15   212-15  Jueves     09:15   10:45   212-09  "},
{ sigla:"LEN324",grupo:"OF",nombre:"Lenguaje II ",docente:"ARDUZ VARGAS YENNY TERESA",Horario:"Lunes     09:15 10:45   212-50   Sabado     10:45   12:15   212-13  "},
{ sigla:"LEN324",grupo:"I6",nombre:"Lenguaje II ",docente:"CASTRO SUAREZ SOLIA",Horario:"Lunes      16:45   18:15   212-16  Viernes    15:15   16:45   212-16  "},
{ sigla:"LEN324",grupo:"I9",nombre:"Lenguaje II ",docente:"CASTRO SUAREZ SOLIA",Horario:"Lunes      19:45   21:15   212-16  Miercoles  18:15   19:45   212-16  "},
{ sigla:"MAT311",grupo:"OF",nombre:"Cálculo I ",docente: "LICHTENSTEIN LECHUGA CLAUDIA ELIZABETH",Horario:"Lunes     07:00   09:15 212-05  Viernes    07:00   09:15   212-05  "},
{ sigla:"MAT311",grupo:"I7",nombre:"Cálculo I ",docente:"GUTIERREZ TITO ROMAN",Horario:"Lunes      16:00   17:30   212-05  Miercoles  17:30   19:00   212-01  Jueves     18:15   19:45   212-01  "},
{ sigla:"MAT311",grupo:"I8",nombre:"Cálculo I ",docente:"GUTIERREZ SUAREZ JOSE LIMBERG ",Horario:"Lunes      19:45   22:00   212-19  Viernes    19:45   22:00   212-06  "},
{ sigla:"OFI111",grupo:"I7",nombre: "Introducción a la Informática",docente:"ROJAS RALDES PATRICIA",Horario:"Lunes     09:15 12:15   212-49  Viernes    08:30   10:00   212-49  "},
{ sigla:"OFI111",grupo:"I6",nombre: "Introducción a la Informática",docente:"TAPIA FLORES LUIS PERCY  ",Horario:"Martes     09:15   11:30   212-52  Jueves     09:15   11:30   212-52  "},
{ sigla:"OFI111",grupo:"I8",nombre: "Introducción a la Informática",docente:"RIBERA ROBLES MARIA DEL CARMEN ",Horario:"Lunes      18:15   19:45   212-51  Miercoles  16:45   19:45   212-51  "},
{ sigla:"OFI111",grupo:"OF",nombre: "Introducción a la Informática",docente:"RIBERA ROBLES MARIA DEL CARMEN ",Horario:"Martes     07:00   09:15   212-52  Jueves     07:00   09:15   212-49  "},
{ sigla:"OFI122",grupo:"I7",nombre:"Productos de Oficina I",docente:"SORIA MEDINA ROSS MARLENY ",Horario:"Lunes     07:00   09:15 212-49  Jueves     10:45   13:00   212-49 07:00   09:15 "},
{ sigla:"OFI122",grupo:"I8",nombre:"Productos de Oficina I",docente:"SORIA MEDINA ROSS MARLENY ",Horario:"Martes     16:00   18:15   212-49  Jueves     16:00   18:15   212-49  "},
{ sigla:"OFI123",grupo:"I8",nombre:"Práctica Profesional I",docente:"ARROYO DURAN LUIS",Horario:"Martes     18:15   22:45   212-14  Jueves     18:15   20:30   212-13  "},
{ sigla:"OFI123",grupo:"I9",nombre:"Práctica Profesional I",docente:"ARROYO DURAN LUIS",Horario:"Miercoles  07:00   11:30   212-15  Viernes    07:00   09:15   212-15  "},
{ sigla:"OFI123",grupo:"OF",nombre:"Práctica Profesional I",docente:"ROJAS RALDES PATRICIA",Horario:"Martes     11:30   13:00   212-14  Miercoles  07:00   12:15   212-17  "},
{ sigla: "EMP221", grupo: "I7", nombre: "Organización de Oficina", docente: "ARDUZ VARGAS YENNY TERESA", Horario:"Sabado  07:00  10:45  212-16 "},
{ sigla: "EMP221", grupo: "I8", nombre: "Organización de Oficina", docente: "ALLERDING VACA DORIS", Horario:"Lunes  18:15   19:45  212-16  Viernes  18:15  20:30  212-11 "},
{ sigla: "INF121", grupo: "I8", nombre: "Programación", docente: "LOPEZ WINNIPEG MARIO MILTON", Horario:"Lunes  11:30  13:00  212-50   Miercoles  11:30  13:00  212-50   Viernes  11:30  13:00  212-50    "},
{ sigla: "INF121", grupo: "I6", nombre: "Programación", docente: "SORIA MEDINA ROSS MARLENY", Horario:"Martes  18:15  20:30  212-52  Jueves  18:15  20:30  212-52 "},
{ sigla: "INF121", grupo: "I7", nombre: "Programación", docente: "LOPEZ WINNIPEG GLORIA SILVIA", Horario:"Lunes  19:00 21:15  212-50  Miercoles  12:15  14:30  212-52 "},
{ sigla: "INF132", grupo: "I9", nombre: "Gráfico por computadora I", docente: "ROJAS RALDES PATRICIA", Horario:"Martes  18:15  21:15  212-50   Jueves  18:15   19:45  212-50  "},
{ sigla: "INF132", grupo: "OF", nombre: "Gráfico por computadora I", docente: "ROJAS RALDES PATRICIA", Horario:"Martes  08:30  10:45  212-50   Jueves  09:15  11:30  212-50  "},
{ sigla: "LEN335", grupo: "OF", nombre: "Inglés Conversacional", docente: "PIZARRO FRANCO CANDELARIA", Horario:"Lunes  14:30  16:00 212-13Jueves  14:30  16:00 212-14 "},
{ sigla: "LEN335", grupo: "I8", nombre: "Inglés Conversacional", docente: "PIZARRO FRANCO CANDELARIA", Horario:"Sabado  07:00  10:00 212-14 "},
{ sigla: "MAT312", grupo: "OF", nombre: "Algebra", docente: "ARTEAGA AGUILERA LOSMAR AUGUSTO", Horario:"Martes  11:30  13:45  212-01Jueves  11:30  13:45  212-01 "},
{ sigla: "MAT323", grupo: "I7", nombre: "Cálculo II", docente: "GUTIERREZ TITO ROMAN", Horario:"Martes  16:00 18:15  212-16  Jueves  16:00 18:15  212-16 "},
{ sigla: "MAT323", grupo: "I8", nombre: "Cálculo II", docente: "VARGAS ALBA HERIBERTO", Horario:"Martes  18:15  20:30  212-16  Jueves  18:15  20:30  212-16 "},
{ sigla: "OFI134", grupo: "I8", nombre: "Productos de Oficina II", docente: "LOPEZ WINNIPEG GLORIA SILVIA", Horario:"Miercoles  19:00  22:45  212-52  Viernes  20:30  22:45  212-52 "},
{ sigla: "OFI134", grupo: "OF", nombre: "Productos de Oficina II", docente: "RIBERA ROBLES MARIA DEL CARMEN", Horario:"Miercoles  07:00 11:30  212-50  "},
{ sigla: "EMP234", grupo: "I8", nombre: "Administración", docente: "ANTELO QUIROGA ROLIN JESUS", Horario:"Martes  20:30  22:45  212-13  Viernes  18:15   19:45  212-03 "},
{ sigla: "EMP234", grupo: "OF", nombre: "Administración", docente: "CABRERA SOLANO RUTH MARISOL", Horario:"Martes  09:15  11:30  212-04  Jueves  10:00 11:30  212-17 "},
{ sigla: "EMP234", grupo: "I7", nombre: "Administración", docente: "ANTELO QUIROGA ROLIN JESUS", Horario:"Lunes  16:00 18:15  212-13  Miercoles  16:45  18:15  212-01 "},
{ sigla: "HAR142", grupo: "I7", nombre: "Teleinformática I", docente: "VASQUEZ ESCOBAR ORLANDO", Horario:"Martes  13:00 16:00 212-49  Jueves  13:00 16:00 212-49 "},
{ sigla: "HAR142", grupo: "I8", nombre: "Teleinformática I", docente: "PAZ MENDOZA ROBERTO CARLOS", Horario:"Jueves  18:15  22:45  212-51 "},
{ sigla: "HAR143", grupo: "OF", nombre: "Sistema Operativo I", docente: "LOPEZ NEGRETTY MARY DUNNIA", Horario:"Lunes  13:00 16:00 212-49  Miercoles  13:00 16:00 212-49 "},
{ sigla: "HAR155", grupo: "I7", nombre: "Soporte Técnico I", docente: "VASQUEZ ESCOBAR ORLANDO", Horario:"Martes  16:00 18:15  212-52  Jueves  16:00 18:15  212-52 "},
{ sigla: "HAR155", grupo: "I8", nombre: "Soporte Técnico I", docente: "BALCAZAR VEIZAGA EVANZ", Horario:"Miercoles  18:15  20:30  212-29 "},
{ sigla: "INF144", grupo: "OF", nombre: "Practica Profesional II", docente: "TAPIA FLORES LUIS PERCY", Horario:"lunes  07:00 12:15  212-19  Miercoles  09:15  10:45  212-19 "},
{ sigla: "INF165", grupo: "OF", nombre: "Grafico por computadora II", docente: "PAZ MENDOZA ROBERTO CARLOS", Horario:"Martes  07:00   09:15  212-49  Jueves  07:00   09:15  212-49 "},
{ sigla: "EMP233", grupo: "I7", nombre: "Contabilidad General", docente: "GALVIS MENDEZ MONICA", Horario:"Lunes  15:15  16:45  212-14  Miercoles  15:15  16:30  212-13 "},
{ sigla: "EMP233", grupo: "OF", nombre: "Contabilidad General", docente: "VALVERDE TERAN LOLA", Horario:"Lunes  18:15  22:45  212-06 "},
{ sigla: "EMP257", grupo: "I9", nombre: "Paquetes Contables", docente: "VALVERDE TERAN LOLA", Horario:"Viernes  09:15  13:00 212-51 "},
{ sigla: "HAR154", grupo: "OF", nombre: "Teleinformática II", docente: "GONZALES SANDOVAL JORGE ANTONIO",Horario:"Lunes  07:00   09:15  212-52  Viernes  18:15  20:30  212-50  "},
{ sigla: "HAR154", grupo: "I8", nombre: "Teleinformática II", docente: "CABALLERO RUA MAURICIO CHRISTIAN",Horario:"Lunes  18:15  20:30  212-52  Viernes  07:00   09:15  212-52 "},
{ sigla: "HAR156", grupo: "I8", nombre: "Sistema Operativo II", docente: "LOPEZ NEGRETTY MARY DUNNIA",Horario:"Lunes  09:15  11:30  212-50 Martes  10:00 12:15  212-49 "},
{ sigla: "HAR156", grupo: "OF", nombre: "Sistema Operativo II", docente: "LOPEZ NEGRETTY MARY DUNNIA",Horario:"Martes  12:15  14:30  212-52  Jueves  12:15  14:30  212-52 "},
{ sigla: "HAR157", grupo: "OF", nombre: "Soporte Técnico II", docente: "FLORES GUZMAN VALENTIN VICTOR",Horario:"Martes  18:15  20:30  212-17  Jueves  16:00 18:15  212-50  "},
{ sigla: "INF143", grupo: "I7", nombre: "Base de Datos I", docente: "SORIA MEDINA ROSS MARLENY",Horario:"Lunes  16:45  18:15  212-52  Miercoles  07:00  10:00 212-52 "},
{ sigla: "EMP245", grupo: "OF", nombre: "Auditoria", docente: "OROSCO GOMEZ RUBEN",Horario:"Martes  07:00   09:15  212-14  Jueves  07:00 08:30  212-13 "},
{ sigla: "EMP245", grupo: "I8", nombre: "Auditoria", docente: "OROSCO GOMEZ RUBEN",Horario:"Lunes  19:45  21:15  212-03  Sabado  08:30  10:45  212-13 "},
{ sigla: "INF166", grupo: "OF", nombre: "Base de Datos II", docente: "SORIA MEDINA ROSS MARLENY",Horario:"Lunes  09:15  12:15  212-52  Jueves  08:30  10:00 212-52 "},
{ sigla: "MAT354", grupo: "I8", nombre: "Estadísticas", docente: "SAUCEDO HURTADO JUAN FERNANDO",Horario:"Martes  20:30  22:45  212-11  Viernes  18:15  20:30  212-16 "},
{ sigla: "SOF141", grupo: "OF", nombre: "Sistemas de Información", docente: "GUTHRIE PACHECO MIGUEL ANGEL",Horario:"Lunes  12:15  13:45  212-49  Martes  12:15  13:45  212-49  Viernes  12:15  13:45  212-49 "},
{ sigla: "SOF164", grupo: "I8", nombre: "Temas Especiales I", docente: "VACA PINTO CESPEDES ROBERTO CARLOS",Horario:"Lunes  18:15   19:45  212-49  Miercoles  18:15  20:30  212-49 "},
{ sigla: "SOF164", grupo: "OF", nombre: "Temas Especiales I", docente: "VACA PINTO CESPEDES ROBERTO CARLOS",Horario:"Martes  13:00 16:00 212-50   Jueves  14:30  16:00 212-50  "},
{ sigla: "SOF166", grupo: "I7", nombre: "Practica Profesional III", docente: "GALVIS MENDEZ MONICA",Horario:"Martes  14:30  16:45  212-30  Jueves  14:30  16:45  212-30  Viernes 14:30  16:45 212-30 "},
{ sigla: "SOF166", grupo: "OF", nombre: "Practica Profesional III", docente: "TAPIA FLORES LUIS PERCY",Horario:"Sabado  10:45  17:30  212-52 "},
{ sigla: "EMP266", grupo: "I8", nombre: "Derecho Informático", docente: "JUSTINIANO FLORES CARMEN LILIAN",Horario:"Jueves  19:45  22:00 212-14  Lunes  20:30  22:00 212-29 "},
{ sigla: "EMP278", grupo: "I8", nombre: "Gestión de Recursos Humanos", docente: "CABRERA SOLANO RUTH MARISOL",Horario:"Martes  18:15  22:00 212-20 "},
{ sigla: "EMP278", grupo: "OF", nombre: "Gestión de Recursos Humanos", docente: "CABRERA SOLANO RUTH MARISOL",Horario:"Miercoles  08:30  12:15  212-05 "},
{ sigla: "EMP279", grupo: "I8", nombre: "Gestión de Riesgos", docente: "SELAYA GARVIZU IVAN VLADISHLAV",Horario:"Lunes  16:45  18:15  212-08  Miercoles  16:45  19:00 212-14 "},
{ sigla: "HAR178", grupo: "I8", nombre: "Seguridad Informática", docente: "UBALDO PEREZ",Horario:"Miercoles  20:30  22:45  212-03  Viernes  13:00  15:15  212-49 "},
{ sigla: "MAT375", grupo: "I7", nombre: "Investigación Operativa", docente: "VACA PINTO CESPEDES ROBERTO CARLOS",Horario:"Martes  18:15   19:45  212-01  Jueves  18:15  20:30  212-49 "},
{ sigla: "SOF163", grupo: "I8", nombre: "Administración Informática", docente: "TAPIA FLORES LUIS PERCY",Horario:"Martes  16:00 18:15  212-11  Jueves  16:00 18:15  212-13 "},
{ sigla: "INF187", grupo: "I8", nombre: "Gestión de Sitios Web", docente: "VACA PINTO CESPEDES ROBERTO CARLOS",Horario:"Lunes  16:00 18:15  212-49  Miercoles  16:45  18:15  212-49 "},
{ sigla: "OFI186", grupo: "I8", nombre: "Gestión de Proyectos", docente: "ROJAS RALDES PATRICIA",Horario:"Martes  07:00 08:30  212-50   Jueves  07:00   09:15  212-50  "},
{ sigla: "SOF152", grupo: "I8", nombre: "Tecnología del Tratamiento", docente: "RIBERA ROBLES MARIA DEL CARMEN",Horario:"Lunes  19:45  22:00 212-49  Miercoles  20:30  22:00 212-49 "},
{ sigla: "SOF187", grupo: "I8", nombre: "Análisis de Datos", docente: "GUTHRIE PACHECO MIGUEL ANGEL",Horario:"Miercoles  12:15  13:45  212-49  Jueves  12:15  14:30  212-50  "},
{ sigla: "SOF188", grupo: "I8", nombre: "Temas especiales II", docente: "SELAYA GARVIZU IVAN VLADISHLAV",Horario:"Miercoles  07:00 08:30  212-50  Viernes  07:00   09:15  212-50  "}

]; const gruposFiltrados = grupos.filter(g => materiasResultado.includes(g.sigla.trim()));

gruposFiltrados.forEach(grupo => {
  const div = document.createElement("div");
  div.className = "tarjeta-grupo";

  const checkbox = document.createElement("input");
  checkbox.type = "checkbox";

  checkbox.onchange = () => {
    const sigla = grupo.sigla.trim();

    if (checkbox.checked) {
      gruposSeleccionados = gruposSeleccionados.filter(g => g.sigla.trim() !== sigla);
      document.querySelectorAll('.tarjeta-grupo input').forEach(cb => {
        const parent = cb.parentElement;
        if (parent.innerText.includes(sigla) && cb !== checkbox) {
          cb.checked = false;
        }
      });

      if (hayConflictoDeHorario(grupo)) {
        alert(`⚠️ Choque de horario: ${sigla}-${grupo.grupo}`);
      }

      gruposSeleccionados.push(grupo);
    } else {
      gruposSeleccionados = gruposSeleccionados.filter(g => g !== grupo);
    }

    resaltarConflictos();
  };

  div.innerHTML = `
    <div class="contenido-grupo">
      <h2>${grupo.sigla} - ${grupo.grupo}</h2>
      <p><strong>Nombre:</strong> ${grupo.nombre}</p>
      <p><strong>Docente:</strong> ${grupo.docente}</p>
      <p><strong>Horario:</strong> ${grupo.Horario}</p>
    </div>
  `;

  div.prepend(checkbox);
  contenedor.appendChild(div);
});


const btn = document.createElement("button");
btn.textContent = "Ver horario de seleccionados";
btn.onclick = mostrarHorariosSeleccionados;
contenedor.appendChild(btn);

function mostrarHorariosSeleccionados() {
  const dias = ["Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"];
  const tablaC = document.getElementById("tabla-horarios");
  tablaC.innerHTML = "";

  if (gruposSeleccionados.length === 0) {
    tablaC.textContent = "No hay grupos seleccionados.";
    return;
  }

  const tabla = document.createElement("table");
  tabla.className = "horario";

  let thead = document.createElement("thead");
  thead.innerHTML = `<tr><th>Hr In</th><th>Hr Fin</th>${dias.map(d=>`<th>${d}</th>`).join("")}</tr>`;
  tabla.appendChild(thead);

  let tbody = document.createElement("tbody");
  const bloques = [];
  let hora=7, min=0;
  for (let i=0; i<21; i++) {
    const hrIn = `${hora.toString().padStart(2,'0')}:${min.toString().padStart(2,'0')}`;
    min += 45;
    if (min>=60) { min-=60; hora++; }
    const hrFin = `${hora.toString().padStart(2,'0')}:${min.toString().padStart(2,'0')}`;
    const tr = document.createElement("tr");
    tr.setAttribute("data-in", hrIn);
    tr.setAttribute("data-out", hrFin);
    tr.innerHTML = `<td>${hrIn}</td><td>${hrFin}</td>${dias.map(_=>`<td></td>`).join("")}`;
    tbody.appendChild(tr);
    bloques.push({hrIn, hrFin, tr});
  }

  const colores = ["#ffcdd2","#f8bbd0","#e1bee7","#d1c4e9","#c5cae9","#bbdefb","#b2ebf2","#c8e6c9","#fff9c4","#ffe0b2","#d7ccc8","#f0f4c3","#b2dfdb","#ffccbc","#e6ee9c","#ce93d8","#80deea","#a5d6a7","#ffab91","#ffecb3"];
  const asignCol = {};
  let colIdx = 0;

  gruposSeleccionados.forEach(g => {
    const key = `${g.sigla.trim()}-${g.grupo}`;
    if (!asignCol[key]) asignCol[key]=colores[colIdx++%colores.length];
    const color = asignCol[key];
    const regex = /(\w+)\s+(\d{1,2}:\d{2})\s+(\d{1,2}:\d{2})/g;
    let m;
    while ((m = regex.exec(g.Horario)) !== null) {
      const [_, dia, hi, hf] = m;
      const di = dias.indexOf(dia);
      if (di < 0) continue;
      bloques.forEach(b => {
        if (b.hrIn>=hi && b.hrFin<=hf) {
          const cell = b.tr.children[2+di];
          cell.textContent += (cell.textContent ? ' / ' : '') + key;
          cell.style.background = color;
          cell.style.fontWeight = 'bold';
        }
      });
    }
  });

  tabla.appendChild(tbody);
  tablaC.appendChild(tabla);
}

function hayConflictoDeHorario(nuevo) {
  const regex = /(\w+)\s+(\d{1,2}:\d{2})\s+(\d{1,2}:\d{2})/g;
  const arr = [];
  let m;
  while ((m = regex.exec(nuevo.Horario))!==null) {
    arr.push({dia:m[1],ini:m[2],fin:m[3]});
  }
  for (let sel of gruposSeleccionados) {
    regex.lastIndex = 0;
    while ((m = regex.exec(sel.Horario))!==null) {
      for (let nh of arr) {
        if (m[1]===nh.dia && traslape(nh.ini, nh.fin, m[2], m[3])) {
          return true;
        }
      }
    }
  }
  return false;
}

function traslape(a1,b1,a2,b2) {
  const t1 = toMin(a1), t2 = toMin(b1), t3 = toMin(a2), t4 = toMin(b2);
  return t1 < t4 && t3 < t2;
}

function toMin(h) {
  const [x, y] = h.split(':').map(Number);
  return x*60 + y;
}

function resaltarConflictos() {
  document.querySelectorAll(".tarjeta-grupo").forEach(div => {
    div.style.border = "";
  });

  for (let i = 0; i < gruposSeleccionados.length; i++) {
    for (let j = i + 1; j < gruposSeleccionados.length; j++) {
      if (hayConflictoDeHorarioEntre(gruposSeleccionados[i], gruposSeleccionados[j])) {
        document.querySelectorAll(".tarjeta-grupo").forEach(div => {
          if (div.innerText.includes(gruposSeleccionados[i].sigla) && div.innerText.includes(gruposSeleccionados[i].grupo)) {
            div.style.border = "3px solid red";
          }
          if (div.innerText.includes(gruposSeleccionados[j].sigla) && div.innerText.includes(gruposSeleccionados[j].grupo)) {
            div.style.border = "3px solid red";
          }
        });
      }
    }
  }
}

function hayConflictoDeHorarioEntre(a, b) {
  const regex = /(\w+)\s+(\d{1,2}:\d{2})\s+(\d{1,2}:\d{2})/g;
  const arrA = [], arrB = [];
  let m;
  while ((m = regex.exec(a.Horario)) !== null) {
    arrA.push({dia: m[1], ini: m[2], fin: m[3]});
  }
  regex.lastIndex = 0;
  while ((m = regex.exec(b.Horario)) !== null) {
    arrB.push({dia: m[1], ini: m[2], fin: m[3]});
  }

  for (let ha of arrA) {
    for (let hb of arrB) {
      if (ha.dia === hb.dia && traslape(ha.ini, ha.fin, hb.ini, hb.fin)) {
        return true;
      }
    }
  }
  return false;
}
}