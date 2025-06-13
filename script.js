function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  if (sidebar.style.width === "60px") {
    sidebar.style.width = "220px";
    document.querySelector(".main-content").style.marginLeft = "220px";
  } else {
    sidebar.style.width = "60px";
    document.querySelector(".main-content").style.marginLeft = "60px";
  }
}


function showTab(index) {
  const tabs = document.querySelectorAll('.tab');
  const contents = document.querySelectorAll('.tab-content');

  tabs.forEach((tab, i) => {
    tab.classList.toggle('active', i === index);
    contents[i].classList.toggle('active', i === index);
  });
}

function toggleDetalles(header) {
  const detalles = header.nextElementSibling;
  detalles.style.display = detalles.style.display === 'block' ? 'none' : 'block';
}

