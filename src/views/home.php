<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="shortcut icon" href="/assets/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/styles.css">
  <style>
    #drop-area.active {
      transform: scale(0.99);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
    }
  </style>
</head>

<body class="flex flex-col">
  <!-- Modal de progreso -->
  <div id="progress-modal" class="fixed inset-0 bg-black/10 flex items-center justify-center hidden z-10">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg w-96">
      <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Procesando archivos</h2>
      <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-4">
        <div id="progress-bar" class="bg-blue-500 h-4 rounded-full" style="width: 0%;"></div>
      </div>
      <p id="progress-text" class="text-gray-800 dark:text-gray-400 text-sm">0 de 0 archivos procesados</p>
    </div>
  </div>
  <!-- Fin del modal de progreso -->

  <div class="flex justify-end">
    <div class="flex border border-gray-500 dark:border-gray-50 rounded-full p-1 mr-4 mt-1 bg-gray-400 dark:bg-gray-800">
      <!-- Light -->
      <label class="cursor-pointer">
        <input type="radio" name="theme" value="light" class="sr-only peer" onclick="setTheme('light')" id="input-light" />
        <div class="rounded bg-transparent text-white peer-checked:bg-primary peer-checked:rounded-full p-1">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
          </svg>
        </div>
      </label>

      <!-- Dark -->
      <label class="cursor-pointer">
        <input type="radio" name="theme" value="dark" class="sr-only peer" onclick="setTheme('dark')" id="input-dark" />
        <div class="rounded bg-transparent text-white peer-checked:bg-primary peer-checked:rounded-full p-1">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
          </svg>
        </div>
      </label>

      <!-- System -->
      <label class="cursor-pointer">
        <input type="radio" name="theme" value="system" class="sr-only peer" onclick="setTheme('system')" id="input-system" />
        <div class="rounded bg-transparent text-white peer-checked:bg-primary peer-checked:rounded-full p-1">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
          </svg>
        </div>
      </label>
    </div>
  </div>

  <div class="text-center p-4 flex gap-4 flex-1 overflow-hidden">
    <!-- Seleccion -->
    <div id="drop-area" class="border-2 border-dashed border-blue-400 rounded-md p-4 bg-primary/10 flex-1/2 cursor-pointer shadow-xl/30 flex gap-2 flex-col justify-center overflow-y-auto">
      <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">Sube tus archivos PDF</h2>
      <p class="text-gray-800 dark:text-gray-400">Puedes arrastrar y soltar tus archivos aquí o hacer clic para seleccionarlos.</p>
      <input type="file" id="file-input" multiple accept="application/pdf" class="hidden" />
    </div>

    <!-- Boton -->
    <div class="relative flex flex-col justify-center items-center max-w-min">
      <button id="btn-clear" class="absolute bg-primary text-white font-bold p-2 rounded-md top-0 flex-1 cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
        </svg>
      </button>

      <button class="cursor-pointer bg-primary text-white font-bold p-2 rounded-md flex items-center" id="btn-rename">
        <p>Renombrar archivos</p>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
          <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    <!-- Resultado -->
    <div id="result-area" class="relative border-2 border-double flex-1/2 rounded-md border-blue-400 p-4 flex flex-col gap-2 shadow-xl/30 overflow-y-auto">
    </div>

    <button class="absolute bottom-6 right-6 bg-primary p-2 rounded-md shadow-md text-white cursor-pointer" onclick="downloadAll()">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
      </svg>
    </button>

  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.0.943/pdf.min.js"></script>
  <script src="/js/index.js"></script>
  <script src="/js/toogleMode.js"></script>
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