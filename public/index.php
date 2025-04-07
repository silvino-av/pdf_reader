<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/^\/api(\/|$)/', $uri)) {
  include_once __DIR__ . '/../src/router/api.php';
  exit;
}

include_once __DIR__ . '/../src/router/web.php';