
const canvas = document.getElementById('network-canvas');
const ctx = canvas.getContext('2d');
canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let nodes = [];

for (let i = 0; i < 100; i++) {
  nodes.push({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    vx: (Math.random() - 0.5) * 0.5,
    vy: (Math.random() - 0.5) * 0.5
  });
}

function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Dibujar nodos
  for (let node of nodes) {
    ctx.beginPath();
    ctx.arc(node.x, node.y, 2, 0, Math.PI * 2);
    ctx.fillStyle = '#003366';
    ctx.fill();
  }

  // Dibujar líneas si están cerca
  for (let i = 0; i < nodes.length; i++) {
    for (let j = i + 1; j < nodes.length; j++) {
      const a = nodes[i];
      const b = nodes[j];
      const dist = Math.hypot(a.x - b.x, a.y - b.y);
      if (dist < 100) {
        ctx.beginPath();
        ctx.moveTo(a.x, a.y);
        ctx.lineTo(b.x, b.y);
        ctx.strokeStyle = `rgba(0, 51, 102, ${1 - dist / 100})`;
        ctx.stroke();
      }
    }
  }

  // Mover nodos
  for (let node of nodes) {
    node.x += node.vx;
    node.y += node.vy;

    // Rebote
    if (node.x < 0 || node.x > canvas.width) node.vx *= -1;
    if (node.y < 0 || node.y > canvas.height) node.vy *= -1;
  }

  requestAnimationFrame(draw);
}

draw();

window.addEventListener('resize', () => {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});

