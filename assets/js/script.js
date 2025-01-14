// Navbar
function toggleMenu() {
  const navbar = document.getElementById("navbar");
  navbar.classList.toggle("active");
}

// Página de Perfil
document.addEventListener('DOMContentLoaded', () => {
  const dragDropArea = document.getElementById('dragDropArea');
  const imageInput = document.getElementById('image');
  const previewImage = document.getElementById('previewImage');

  // Clique para abrir o seletor de arquivos
  dragDropArea.addEventListener('click', () => {
    imageInput.click();
  });

  // Atualiza a imagem de visualização ao selecionar um arquivo
  imageInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.src = e.target.result;
        previewImage.style.border = "4px solid #4caf50"; // Altera a borda
      };
      reader.readAsDataURL(file);
    }
  });

  // Drag and Drop
  dragDropArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragDropArea.classList.add('drag-over');
  });

  dragDropArea.addEventListener('dragleave', () => {
    dragDropArea.classList.remove('drag-over');
  });

  dragDropArea.addEventListener('drop', (event) => {
    event.preventDefault();
    dragDropArea.classList.remove('drag-over');

    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      imageInput.files = event.dataTransfer.files;

      const reader = new FileReader();
      reader.onload = (e) => {
        previewImage.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      alert('Por favor, envie um arquivo de imagem válido.');
    }
  });
});

// Página de Contato
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const displayData = document.getElementById("displayData");
  const clearDataButton = document.getElementById("clearDataButton");

  // Salvar os dados no Web Storage
  form.addEventListener("submit", (event) => {
    event.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const subject = document.getElementById("subject").value;
    const message = document.getElementById("message").value;

    localStorage.setItem("contactName", name);
    localStorage.setItem("contactEmail", email);
    localStorage.setItem("contactPhone", phone);
    localStorage.setItem("contactSubject", subject);
    localStorage.setItem("contactMessage", message);

    alert("Mensagem enviada! Seus dados foram enviados.")
    displaySavedData();
    form.reset();
  });

  // Exibir os dados salvos
  function displaySavedData() {
    const name = localStorage.getItem("contactName");
    const email = localStorage.getItem("contactEmail");
    const phone = localStorage.getItem("contactPhone");
    const subject = localStorage.getItem("contactSubject");
    const message = localStorage.getItem("contactMessage");

    if (name || email || phone || subject || message) {
      displayData.innerHTML = `
        <p><strong>Nome:</strong> ${name || "N/A"}</p>
        <p><strong>E-mail:</strong> ${email || "N/A"}</p>
        <p><strong>Telefone:</strong> ${phone || "N/A"}</p>
        <p><strong>Assunto:</strong> ${subject || "N/A"}</p>
        <p><strong>Mensagem:</strong> ${message || "N/A"}</p>
      `;
      clearDataButton.style.display = "block"; // Exibir o botão de limpar dados
    } else {
      displayData.innerHTML = "<p>Nenhum dado salvo.</p>";
      clearDataButton.style.display = "none"; // Ocultar o botão de limpar dados
    }
  }

  // Limpar os dados do Web Storage
  clearDataButton.addEventListener("click", () => {
    localStorage.clear();
    displaySavedData(); // Atualiza a exibição após a limpeza
  });

  // Exibir dados salvos ao carregar a página
  displaySavedData();
});
