<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="shortcut icon" href="/assets/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/styles.css">
</head>

<body class="bg-gray-100 dark:bg-gray-900 flex items-center justify-center min-h-screen transition-colors duration-300">

  <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-xl w-full max-w-md">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white text-center mb-6">Iniciar sesión</h2>

    <form class="space-y-5">
      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Contraseña -->
      <div>
        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Botón -->
      <div>
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700 transition duration-200 font-semibold">
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
    // Intercepta el envío del formulario y realiza la petición a la API
    document.querySelector("form").addEventListener("submit", function(e) {
      e.preventDefault();
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
          alert("Error: " + data.message);
        }
      })
      .catch(err => console.error("Error al iniciar sesión:", err));
    });
  </script>

</body>

</html>