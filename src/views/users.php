<?php require_once __DIR__ . '/../models/UserModel.php'; ?>


<?php if ($_SESSION['role'] !== 'admin') {
  header("Location: /");
  exit;
} ?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>
  <link rel="shortcut icon" href="/assets/logo-black.png" type="image/x-icon">
  <link rel="stylesheet" href="/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
</head>

<body>
  
  <div class="p-4">
    <?php include_once __DIR__ . '/../components/header.php'; ?>
    <div id="container-table-users">
      <table id="default-table"></table>
    </div>

    <!-- Modal -->
    <div
      id="modal"
      aria-checked="false"
      class="group fixed inset-0 z-50 flex items-center justify-center p-4 pointer-events-none opacity-0 invisible transition-all duration-300 aria-checked:opacity-100 aria-checked:pointer-events-auto aria-checked:visible">
      <!-- Backdrop -->
      <div
        onclick="toggleModal()"
        class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300 group-aria-checked:opacity-100 cursor-pointer"></div>

      <!-- Contenido del modal -->
      <div
        class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 transform scale-95 opacity-0 transition-all duration-300 group-aria-checked:scale-100 group-aria-checked:opacity-100">
        <!-- Botón de cerrar -->
        <button
          onclick="toggleModal()"
          class="absolute top-4 right-4 p-1 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 cursor-pointer transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Contenido -->
        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4">Formulario</h3>

        <form class="space-y-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
            <input type="text" id="name" name="name" required
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-colors">
          </div>

          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo</label>
            <input type="email" id="email" name="email" required
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-colors">
          </div>

          <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol</label>
            <select id="role" name="role" required
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-colors">
              <option value="" disabled selected>Selecciona un rol</option>
              <option value="admin">Administrador</option>
              <option value="user">Usuario</option>
            </select>
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
            <input type="text" id="password" name="password" required autocomplete="off"
              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-colors">
          </div>

          <div class="flex justify-end space-x-3 pt-2">
            <button
              type="button"
              onclick="toggleModal()"
              class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md transition-colors">
              Cancelar
            </button>
            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary/50 rounded-md shadow-sm transition-colors">
              Enviar
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const users = <?php echo getUsers(); ?>;
  </script>
  <script src="/js/users.js"></script>
</body>

</html>