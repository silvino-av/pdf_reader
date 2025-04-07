// drag and drop
let selectedFiles = [];
const fileInput = document.getElementById("file-input");
const dropArea = document.getElementById("drop-area");
const btnRename = document.getElementById("btn-rename");
const resultArea = document.getElementById("result-area");
const btnClear = document.getElementById("btn-clear");
const loader = document.getElementById("loader");
const progressModal = document.getElementById("progress-modal");
const progressBar = document.getElementById("progress-bar");
const progressText = document.getElementById("progress-text");
let pdfReader = pdfjsLib

dropArea.addEventListener("click", () => fileInput.click());
fileInput.addEventListener("change", (event) => handleFiles(event.target.files));

// Arrastrar y soltar
dropArea.addEventListener("dragover", (event) => {
  event.preventDefault();
  dropArea.classList.replace("bg-primary/10", "bg-primary/40");
});

dropArea.addEventListener("dragleave", () => {
  dropArea.classList.replace("bg-primary/40", "bg-primary/10");
});

dropArea.addEventListener("drop", (event) => {
  event.preventDefault();
  dropArea.classList.replace("bg-primary/40", "bg-primary/10");
  handleFiles(event.dataTransfer.files);
});

async function handleFiles(files) {
  // console.log(`Archivos seleccionados: ${files?.length}`)
  selectedFiles = [];


  // for (let i = 0; i < 10; i++) {
  for (const file of files) {
    if (file.type !== "application/pdf") {
      alert("Solo se permiten archivos PDF");
      return;
    }
    selectedFiles.push(file);
  }
  // }

  mostrarArchivos();
  fileInput.value = null;
}

function mostrarArchivos() {
  dropArea.innerHTML = "";
  dropArea.classList.remove("justify-center");
  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];
    const fileElement = document.createElement("div");
    fileElement.id = `file-${i}`;
    fileElement.className = "rounded-md border border-primary py-1 px-3 flex justify-between bg-white dark:bg-gray-800 shadow-md overflow-hidden min-h-max";
    fileElement.innerHTML = `
      <p class="flex items-center gap-3 wrap-anywhere">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 min-w-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        ${file.name}
      </p>
      <button class="cursor-pointer text-red-500" onclick="event.stopPropagation(); removeFile('${fileElement.id}');" onmousedown="event.stopPropagation();">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    `;
    dropArea.appendChild(fileElement);
  }
}

function removeFile(id) {
  // console.log(`Archivo eliminado: ${id}`);
  const fileElement = document.getElementById(id);
  const index = selectedFiles.findIndex(file => file.name === fileElement.innerText.trim());
  if (index !== -1) {
    selectedFiles.splice(index, 1);
  }
  fileElement.remove();
}

btnRename.addEventListener("click", async () => {
  resultArea.innerHTML = "";
  progressModal.classList.remove("hidden");
  progressBar.style.width = "0%";
  progressText.textContent = `0 de ${selectedFiles.length} archivos procesados`;

  for (let i = 0; i < selectedFiles.length; i++) {
    const file = selectedFiles[i];
    try {
      const arrayBuffer = await file.arrayBuffer();
      const loadingTask = pdfReader.getDocument({ data: arrayBuffer });
      const pdfDocument = await loadingTask.promise;
      const page = await pdfDocument.getPage(1);
      const textContent = await page.getTextContent();
      const textItems = textContent.items;
      const indexIni = textItems.findIndex(item => item.str.includes('Cuenta Abono'));
      const indexFin = textItems.findIndex(item => item.str.includes('Importe'));

      const text = textItems.slice(indexIni + 1, indexFin).map(item => item.str).join(' ');
      const nameFile = text.split('-')[1]?.trim() || null;

      if (nameFile) {
        const blob = new Blob([arrayBuffer], { type: 'application/pdf' });
        const url = URL.createObjectURL(blob);

        resultArea.insertAdjacentHTML('beforeend', `<div class="rounded-md border border-primary py-1 px-3 flex justify-between bg-primary/10 dark:bg-gray-800 shadow-md overflow-hidden min-h-max">
            <p class="flex items-center gap-3 wrap-anywhere">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 min-w-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
              </svg>
              ${nameFile}.pdf
            </p>
            <a href="${url}" class="cursor-pointer text-primary" download="${nameFile}.pdf">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
              </svg>
            </a>
          </div>`);
      } else {
        throw new Error('No se encontró el string en el PDF');
      }
    } catch (error) {
      resultArea.insertAdjacentHTML('beforeend', `<div class="rounded-md border border-red-500 py-1 px-3 flex justify-between bg-red-100 dark:bg-gray-800 shadow-md overflow-hidden min-h-max">
        <p class="flex items-center gap-3 wrap-anywhere">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 min-w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 3v.008M12 5.25v-.008M4.5 12a7.5 7.5 0 1 1 15 0A7.5 7.5 0 0 1 4.5 12Z" />
          </svg>
          ${file.name}
        </p>
      </div>`);
      console.error('Error al procesar el archivo:', file.name, error);
      fetch('/logError', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ error: error.toString(), fileName: file.name })
      }).catch(err => console.error('Error logging failed:', err));
    }

    // Actualizar progreso
    const progress = ((i + 1) / selectedFiles.length) * 100;
    progressBar.style.width = `${progress}%`;
    progressText.textContent = `${i + 1} de ${selectedFiles.length} archivos procesados`;
  }

  progressModal.classList.add("hidden");
});

function downloadAll() {
  const links = resultArea.querySelectorAll('a');
  links.forEach(link => {
    link.click();
  });
}

btnClear.addEventListener("click", () => {
  // console.log('Limpiando archivos seleccionados');
  dropArea.classList.add("justify-center");
  dropArea.innerHTML = `<h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Sube tus archivos PDF</h2>
      <p class="text-gray-800 dark:text-gray-400">Puedes arrastrar y soltar tus archivos aquí o hacer clic para seleccionarlos.</p>`;
  resultArea.innerHTML = "";
  selectedFiles = [];
});
