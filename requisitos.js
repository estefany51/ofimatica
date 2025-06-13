const relaciones = {
  "EMP210": { directos: [], indirectos: ["LEN324", "OFI123"] },
  "HAR111": { directos: [], indirectos: ["OFI111"] },
  "LEN311": { directos: [], indirectos: ["LEN323"] },
  "LEN312": { directos: [], indirectos: ["OFI122", "LEN324", "OFI123"] },
  "MAT310": { directos: [], indirectos: ["MAT311"] },

  "OFI111": { directos: ["HAR111"], indirectos: ["INF121", "INF132"] },
  "OFI122": { directos: ["LEN312"], indirectos: ["OFI134"] },
  "LEN324": { directos: ["LEN312", "EMP210"], indirectos: ["EMP221"] },
  "MAT311": { directos: ["MAT310"], indirectos: ["MAT323", "MAT312"] },
  "OFI123": { directos: ["LEN312", "EMP210"], indirectos: [] },
  "LEN323": { directos: ["LEN311"], indirectos: ["LEN335"] },

  "LEN335": { directos: ["LEN323","LEN311"], indirectos: [""] },
  "OFI134": { directos: ["OFI122","LEN312"], indirectos: ["INF144","OFI145"] },
  "MAT323": { directos: ["MAT311","MAT310"], indirectos: ["INF144"] },
  "INF121": { directos: ["OFI111","HAR111"], indirectos: ["INF144","OFI145","HAR142","HAR155","HAR143"] },
  "INF132": { directos: ["OFI111","HAR111"], indirectos: ["INF144","INF165"] },
  "EMP221": { directos: ["LEN324","LEN312","EMP210"], indirectos: ["INF144","EMP234"] },
  "MAT312": { directos: ["MAT311","MAT310"], indirectos: ["INF144","HAR143"] },

  "INF144": { directos: ["OFI134","MAT323","EMP221","INF121","INF132","MAT312", "MAT311", "OFI122","LEN324", "MAT311","MAT310", "LEN312", "HAR111","EMP210"], indirectos: ["SOF166"] },
  "INF165": { directos: ["INF132","OFI111","HAR111"], indirectos: ["INF187"] },
  "HAR142": { directos: ["INF121","OFI111","HAR111"], indirectos: ["HAR154"] },
  "HAR155": { directos: ["INF121","OFI111","HAR111"], indirectos: ["HAR157"] },
  "HAR143": { directos: ["INF121","MAT312","OFI111","HAR111","MAT311","MAT310"], indirectos: ["HAR156"] },
  "EMP234": { directos: ["EMP221","LEN324","LEN312","EMP210"], indirectos: ["EMP257","EMP233"] },
  "OFI145": { directos: ["INF121","OFI134","OFI111","OFI122","LEN312","HAR111"], indirectos: ["INF143"] },

    "EMP257": { directos: ["EMP234"], indirectos: ["EMP245","SOF166"] },
  "INF143": { directos: ["OFI145"], indirectos: ["INF166","SOF141","SOF166"] },
  "HAR156": { directos: ["HAR143"], indirectos: ["SOF164","SOF166"] },
  "HAR154": { directos: ["HAR142"], indirectos: ["SOF164","SOF166"] },
  "EMP233": { directos: ["EMP234"], indirectos: ["EMP245","SOF166"] },
  "HAR157": { directos: ["HAR155"], indirectos: ["SOF166"] },

  "EMP245": { directos: ["EMP257","EMP233"], indirectos: ["EMP278","EMP266","GRT001","GDIT01"] },
  "SOF164": { directos: ["HAR156","HAR154"], indirectos: ["GRT001","GDIT01"] },
  "SOF166": { directos: ["EMP257","INF143","HAR156","HAR154","EMP233","HAR157"], indirectos: ["GRT001","GDIT01"] },
  "INF166": { directos: ["INF143"], indirectos: ["SOF163","GRT001","GDIT01"] },
  "SOF141": { directos: ["INF143"], indirectos: ["HAR178","SOF163","EMP279","GRT001","GDIT01"] },
  "MAT354": { directos: ["OFI145"], indirectos: ["EMP278","MAT375","GRT001","GDIT01"] },

  "EMP278": { directos: ["EMP245","MAT354"], indirectos: ["OFI186","GDI001","GRL001","GRT001","GDIT01"] },
  "MAT375": { directos: ["MAT354"], indirectos: ["SOF187","GRT001","GDIT01","GDI001","GRL001"] },
  "HAR178": { directos: ["SOF141"], indirectos: ["SOF188","SOF187","GRT001","GDIT01","GDI001","GRL001"] },
  "SOF163": { directos: ["INF166","SOF141"], indirectos: ["SOF152","GRT001","GDIT01","GDI001","GRL001"] },
  "EMP279": { directos: ["SOF141"], indirectos: ["OFI186","GRT001","GDIT01","GDI001","GRL001"] },
  "EMP266": { directos: ["EMP245"], indirectos: ["OFI186","GRT001","GDIT01","GDI001","GRL001"] },

  "SOF188": { directos: ["HAR178"], indirectos: ["","GRT001","GDIT01","GDI001","GRL001"] },
  "INF187": { directos: ["HAR178"], indirectos: ["","GRT001","GDIT01","GDI001","GRL001"] },
  "SOF152": { directos: ["SOF163"], indirectos: ["","GRT001","GDIT01","GDI001","GRL001"] },
  "OFI186": { directos: ["EMP278","EMP279"], indirectos: ["","GRT001","GDIT01","GDI001","GRL001"] },
  "SOF187": { directos: ["MAT375"], indirectos: ["","GRT001","GDIT01","GDI001","GRL001"] }

};

// Generar tabla inversa de prerequisitos directos
const prerequisitosDirectos = {};
for (const [materia, habilitadas] of Object.entries(relaciones)) {
  for (const destino of habilitadas.indirectos) {
    if (!destino) continue; // Evitar elementos vacíos
    if (!prerequisitosDirectos[destino]) prerequisitosDirectos[destino] = new Set();
    prerequisitosDirectos[destino].add(materia);
  }
}

// Materias del primer semestre
const materiasPorSemestre = {
  1: ["EMP210", "HAR111", "LEN311", "LEN312", "MAT310"]
};

// Función recursiva para obtener requisitos indirectos
function obtenerRequisitosIndirectos(materia, visitado = new Set()) {
  const indirectos = new Set();
  const directos = prerequisitosDirectos[materia] || new Set();

  for (const req of directos) {
    if (!visitado.has(req)) {
      visitado.add(req);
      indirectos.add(req);
      const sub = obtenerRequisitosIndirectos(req, visitado);
      sub.forEach(s => indirectos.add(s));
    }
  }
  return indirectos;
}

// Función principal para verificar requisitos
function verificarRequisitos() {
  const materiasTomadas = new Set(
    [...document.querySelectorAll('input[name="materia"]:checked')].map(i => i.value)
  );

  const resultado = [];
  const prioritarias = [];

  const primerSemestre = materiasPorSemestre[1];
  const noTomadasPrimerSemestre = primerSemestre.filter(m => !materiasTomadas.has(m));

  if (materiasTomadas.size === 0) {
    for (const materia of primerSemestre) {
      prioritarias.push({ materia, directos: [], indirectos: [] });
    }
    mostrarResultado(prioritarias);
    return;
  }

  // Siempre mostrar materias de primer semestre que no se han tomado
  for (const materia of noTomadasPrimerSemestre) {
    prioritarias.push({ materia, directos: [], indirectos: [] });
  }

  // Evaluar materias habilitadas por prerequisitos
  for (const materia of Object.keys(prerequisitosDirectos)) {
    if (materiasTomadas.has(materia)) continue;

    const directos = prerequisitosDirectos[materia];
    const requisitosDirectosCompletos = [...directos].every(req => materiasTomadas.has(req));
    if (!requisitosDirectosCompletos) continue;

    const indirectos = obtenerRequisitosIndirectos(materia);
    const indirectosFaltantes = [...indirectos].filter(req => !materiasTomadas.has(req));
    if (indirectosFaltantes.length > 0) continue;

    resultado.push({
      materia,
      directos: [...directos],
      indirectos: [] // Se puede agregar más adelante si se desea mostrar
    });
  }

  mostrarResultado([...prioritarias, ...resultado]);
}

// Mostrar resultados en la interfaz
function mostrarResultado(resultados) {
  const contenedor = document.getElementById("resultado-requisitos");
  contenedor.innerHTML = "";

  if (resultados.length === 0) {
    contenedor.innerHTML = "<li>No hay materias habilitadas aún.</li>";
    return;
  }

  for (const item of resultados) {
    const li = document.createElement("li");
    li.innerHTML = `
      <strong>${item.materia}</strong><br>
      <span style="color: green;">Requisitos directos: ${item.directos.join(", ") || "Ninguno"}</span>
    `;
    contenedor.appendChild(li);
  }

  // Obtener solo las siglas de materias para filtrar grupos
  const materias = resultados.map(r => r.materia);

  // Llamar a cargarGrupos con materias habilitadas
  cargarGrupos(materias);
}
