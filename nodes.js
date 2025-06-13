const canvas = document.getElementById('node-background');
const ctx = canvas.getContext('2d');
let width, height;
let nodes = [];
const nodeCount = 70;
const maxDistance = 150;

// Nodo individual
class Node {
  constructor(x, y, vx, vy) {
    this.x = x;
    this.y = y;
    this.vx = vx; // velocidad horizontal
    this.vy = vy; // velocidad vertical
  }

  move() {
    this.x += this.vx;
    this.y += this.vy;

    if(this.x < 0 || this.x > width) this.vx *= -1;
    if(this.y < 0 || this.y > height) this.vy *= -1;
  }

  draw() {
    ctx.beginPath();
    ctx.arc(this.x, this.y, 2.5, 0, Math.PI * 2);
    ctx.fillStyle = 'rgba(0, 188, 212, 0.6)'; // cian semitransparente
    ctx.fill();
  }
}

function init() {
  resize();
  nodes = [];
  for(let i=0; i < nodeCount; i++) {
    let x = Math.random() * width;
    let y = Math.random() * height;
    let vx = (Math.random() - 0.5) * 0.7;
    let vy = (Math.random() - 0.5) * 0.7;
    nodes.push(new Node(x, y, vx, vy));
  }
  animate();
}

function resize() {
  width = window.innerWidth;
  height = window.innerHeight;
  canvas.width = width;
  canvas.height = height;
}

function animate() {
  ctx.clearRect(0, 0, width, height);

  // Dibuja líneas entre nodos cercanos
  for(let i = 0; i < nodeCount; i++) {
    let nodeA = nodes[i];
    for(let j = i + 1; j < nodeCount; j++) {
      let nodeB = nodes[j];
      let dx = nodeA.x - nodeB.x;
      let dy = nodeA.y - nodeB.y;
      let dist = Math.sqrt(dx * dx + dy * dy);
      if(dist < maxDistance) {
        ctx.strokeStyle = `rgba(0, 188, 212, ${1 - dist / maxDistance})`;
        ctx.lineWidth = 1;
        ctx.beginPath();
        ctx.moveTo(nodeA.x, nodeA.y);
        ctx.lineTo(nodeB.x, nodeB.y);
        ctx.stroke();
      }
    }
  }

  // Mueve y dibuja cada nodo
  nodes.forEach(node => {
    node.move();
    node.draw();
  });

  requestAnimationFrame(animate);
}

// Ajustar tamaño al cambiar ventana
window.addEventListener('resize', resize);

init();
