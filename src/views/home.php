<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio</title>
  <link rel="shortcut icon" href="/assets/logo-black.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/styles.css">
  <style>
    #drop-area.active {
      transform: scale(0.99);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body class="flex flex-col p-4 gap-4">

  <?php include_once __DIR__ . '/../components/header.php'; ?>

  <div class="text-center flex gap-4 flex-1 overflow-hidden">
    <!-- Seleccion -->
    <div id="drop-area" class="border-2 border-dashed border-blue-400 rounded-md p-4 bg-primary/10 flex-1/2 cursor-pointer shadow-xl/30 flex gap-2 flex-col justify-center overflow-y-auto">
      <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Sube tus archivos PDF</h2>
      <p class="text-gray-800 dark:text-gray-400">Puedes arrastrar y soltar tus archivos aquí o hacer clic para seleccionarlos.</p>
      <input type="file" id="file-input" multiple accept="application/pdf" class="hidden" />
    </div>

    <!-- Boton -->
    <div class="relative flex flex-col justify-center items-center max-w-min">
      <div class="absolute group top-0">
        <button id="btn-clear" class="bg-primary text-white font-bold p-2 rounded-md cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
          </svg>
        </button>
        <div class="absolute -left-3 top-12 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded">
          Limpiar archivos
        </div>
      </div>

      <button class="cursor-pointer bg-primary text-white font-bold p-2 rounded-md flex items-center" id="btn-rename">
        <p>Renombrar archivos</p>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-8">
          <path fill-rule="evenodd" d="M12.97 3.97a.75.75 0 0 1 1.06 0l7.5 7.5a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 1 1-1.06-1.06l6.22-6.22H3a.75.75 0 0 1 0-1.5h16.19l-6.22-6.22a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>

    <!-- Resultado -->
    <div id="result-area" class="relative border-2 border-double flex-1/2 rounded-md border-blue-400 p-4 flex flex-col gap-2 shadow-xl/30 overflow-y-auto">
    </div>

    <div class="group absolute bottom-6 right-6">
      <button class="bg-primary p-2 rounded-md shadow-md text-white cursor-pointer" onclick="downloadAll()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
        </svg>
      </button>
      <div class="absolute right-12 -top-2 hidden group-hover:block bg-gray-800 text-white text-xs px-2 py-1 rounded">
        Descargar todos los archivos
      </div>
    </div>

  </div>

  <!-- Modal de progreso -->
  <div id="progress-modal" class="fixed inset-0 bg-black/10 flex items-center justify-center z-10 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg w-96">
      <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Procesando archivos</h2>
      <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-4">
        <div id="progress-bar" class="bg-blue-500 h-4 rounded-full" style="width: 0%;"></div>
      </div>
      <p id="progress-text" class="text-gray-800 dark:text-gray-400 text-sm">0 de 0 archivos procesados</p>
    </div>
  </div>
  <!-- Fin del modal de progreso -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
  <script src="/js/index.js"></script>
  <script>
    document.getElementById('drop-area').addEventListener('mousedown', function() {
      this.classList.add('active');
    });
    document.getElementById('drop-area').addEventListener('mouseup', function() {
      this.classList.remove('active');
    });
    document.getElementById('drop-area').addEventListener('mouseleave', function() {
      this.classList.remove('active');
    });
  </script>
</body>

</html>