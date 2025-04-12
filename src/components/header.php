<?php $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''; ?>

<style>
  .nav-link::before {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 3px;
    background: #000;
    transition: width 0.3s ease-in-out;
  }

  .nav-link:hover::before {
    width: 100%;
  }

  .dark .nav-link::before {
    background: #fff;
  }
</style>

<header class="flex items-center bg-white dark:bg-gray-800 rounded-lg inset-shadow-sm inset-shadow-gray-300 p-4 gap-2">

  <div class="w-30 h-auto flex justify-center items-center pr-4 border-r-2 border-gray-500 dark:border-gray-50">
    <img id="img-logo" src="/assets/logo-black.png" alt="logo">
  </div>

  <nav class="flex gap-4">
    <? if ($uri !== "/users" && $_SESSION['role'] === 'admin') { ?>
      <!-- Enlace a Usuarios -->
      <a href="/users" class="nav-link relative text-black dark:text-white font-bold py-2 px-4 hover:scale-105 transform transition duration-300 shadow-md rounded-md dark:shadow-white/30">
        Usuarios
      </a>
    <? } ?>
    <? if ($uri !== "/home" && $uri !== "/" && $uri !== "") { ?>
      <!-- Enlace a Usuarios -->
      <a href="/home" class="nav-link relative text-black dark:text-white font-bold py-2 px-4 hover:scale-105 transform transition duration-300 shadow-md rounded-md dark:shadow-white/30">
        Inicio
      </a>
    <? } ?>
  </nav>

  <div class="flex-1"></div>

  <!-- log out -->
  <button id="logout-button" class="flex justify-center items-center w-10 h-10 shadow-md rounded-md dark:shadow-white/30 hover:scale-110 transform transition duration-300">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-400">
      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
    </svg>
  </button>

  <div class="flex rounded-md p-1 h-10 shadow-md dark:shadow-white/30">
    <!-- Light -->
    <label class="cursor-pointer hover:scale-125 transform transition duration-200">
      <input type="radio" name="theme" value="light" class="sr-only peer" onclick="setTheme('light')" id="input-light" />
      <div class="bg-transparent text-black dark:text-white peer-checked:text-white peer-checked:bg-primary rounded-md p-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>
      </div>
    </label>

    <!-- Dark -->
    <label class="cursor-pointer hover:scale-125 transform transition duration-200">
      <input type="radio" name="theme" value="dark" class="sr-only peer" onclick="setTheme('dark')" id="input-dark" />
      <div class="bg-transparent text-black dark:text-white peer-checked:text-white peer-checked:bg-primary rounded-md p-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
      </div>
    </label>

    <!-- System -->
    <label class="cursor-pointer hover:scale-125 transform transition duration-200">
      <input type="radio" name="theme" value="system" class="sr-only peer" onclick="setTheme('system')" id="input-system" />
      <div class="bg-transparent text-black dark:text-white peer-checked:text-white peer-checked:bg-primary rounded-md p-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
        </svg>
      </div>
    </label>
  </div>
</header>

<script src="/js/toogleMode.js"></script>