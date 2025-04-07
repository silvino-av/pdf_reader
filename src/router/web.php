<?php
// Iniciar la sesión si no está iniciada
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';

// Si está autenticado y se intenta acceder a "/login", redirigir a home
if ($uri === '/login' && isset($_SESSION['user'])) {
    header("Location: /home");
    exit;
}

// Si la solicitud no es para el login y no hay un usuario autenticado, redirigir a login
if ($uri !== '/login' && !isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}

$trimmed = trim($uri, '/');
$segments = explode('/', $trimmed);
$view = array_shift($segments);
$view = !empty($view) ? $view : 'home';
$viewFile = __DIR__ . '/../views/' . $view . '.php';

if (file_exists($viewFile)) {
  require_once $viewFile;
} else {
  require_once __DIR__ . '/../views/404.php';
  // http_response_code(404);
  // echo "View file not found.";
}