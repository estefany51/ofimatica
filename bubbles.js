const bubblesWrapper = document.createElement('div');
bubblesWrapper.classList.add('bubbles-wrapper');
document.body.appendChild(bubblesWrapper);

const NUM_BUBBLES = 30;

function createBubble(i) {
  const bubble = document.createElement('div');
  bubble.classList.add('bubble');

  // Tamaño random entre 15px y 40px
  const size = 15 + Math.random() * 25;
  bubble.style.width = `${size}px`;
  bubble.style.height = `${size}px`;

  // Posición horizontal random en viewport
  bubble.style.left = `${Math.random() * 100}vw`;

  // Delay random para que no suban todas igual
  bubble.style.animationDelay = `${Math.random() * 8}s`;

  // Cuando el mouse pase sobre la burbuja, se "revienta"
  bubble.style.pointerEvents = 'auto'; // para que reciba eventos mouse
  bubble.addEventListener('mouseenter', () => {
    bubble.style.animationName = 'pop';
    bubble.style.animationDuration = '0.4s';
    bubble.style.animationIterationCount = '1';
    bubble.style.pointerEvents = 'none'; // ya no responde

    // Al terminar animación, se elimina y se crea otra burbuja nueva
    bubble.addEventListener('animationend', () => {
      bubble.remove();
      createBubble(0);
    }, { once: true });
  });

  bubblesWrapper.appendChild(bubble);
}

// Crear todas las burbujas iniciales
for (let i = 0; i < NUM_BUBBLES; i++) {
  createBubble(i);
}
// bubbles.js
const wrapper = document.querySelector('.bubbles-wrapper');

for (let i = 0; i < 30; i++) {
  const bubble = document.createElement('div');
  bubble.classList.add('bubble');
  bubble.style.left = `${Math.random() * 100}%`;
  bubble.style.animationDuration = `${4 + Math.random() * 6}s`;
  bubble.style.opacity = Math.random();
  bubble.style.fontSize = `${10 + Math.random() * 20}px`;
  wrapper.appendChild(bubble);
}
