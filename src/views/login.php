<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sessión</title>
  <link rel="shortcut icon" href="/assets/logo-black.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/styles.css">
</head>

<style>
  body {
    background-image: url('https://cdn.prod.website-files.com/665a1b5e28831abe5cc87e85/6691bed004da5c5006c1538e_Barrels-p-2000.webp');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-color: #f3f4f6;
    /* Color de fondo para el modo claro */
    transition: background-color 0.3s ease;
  }
</style>

<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen transition-colors duration-300">

  <div class="backdrop-blur-md p-8 rounded-2xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-bold text-white text-center mb-6">Iniciar sesión</h2>

    <form class="space-y-5">
      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Correo electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          class="w-full px-4 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary" />
      </div>

      <!-- Contraseña -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="w-full px-4 py-2 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary" />
      </div>

      <!-- Botón -->
      <div>
        <button
          type="submit"
          class="w-full bg-primary text-white py-2 rounded-xl hover:bg-primary/80 transition duration-200 font-semibold flex justify-center items-center gap-2">
          <svg class="size-5 animate-spin text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Ingresar
        </button>
      </div>
    </form>

    <!-- Link adicional -->
    <!-- <p class="text-sm text-center text-gray-600 dark:text-gray-400 mt-6">
      ¿Olvidaste tu contraseña?
      <a href="#" class="text-blue-600 hover:underline">Recupérala aquí</a>
    </p> -->
  </div>

  <script src="/js/toogleMode.js"></script>
  <script>
    const spinner = document.querySelector("svg");
    const button = document.querySelector("button");

    // Función para mostrar el spinner
    function start() {
      // Muestra el spinner
      spinner.classList.remove("hidden");
      spinner.classList.add("animate-spin");
      // Desactiva el botón
      button.disabled = true;
      button.classList.add("opacity-50");
      button.classList.remove("hover:bg-primary/80");
    }

    // Función para ocultar el spinner
    function stop() {
      // Oculta el spinner
      spinner.classList.add("hidden");
      spinner.classList.remove("animate-spin");
      // Reactiva el botón
      button.disabled = false;
      button.classList.remove("opacity-50");
      button.classList.add("hover:bg-primary/80");
    }

    // Intercepta el envío del formulario y realiza la petición a la API
    document.querySelector("form").addEventListener("submit", function(e) {
      e.preventDefault();
      // Muestra el spinner
      start();
      // Realiza la petición a la API
      const formData = new FormData(this);
      fetch("api/login", {
          method: "POST",
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            window.location.href = "home";
          } else {
            alert(data.message);
            // Oculta el spinner
            stop();
          }
        })
        .catch(err => {
          alert("Error al iniciar sesión. Por favor, intenta de nuevo.");
          console.error("Error al iniciar sesión:", err)
          // Oculta el spinner
          stop();
        })
    });
  </script>

</body>

</html>