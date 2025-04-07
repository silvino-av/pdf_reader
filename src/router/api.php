<?php
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';

if ($uri === '/api/login') {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['message' => 'Método no permitido']);
        exit;
    }
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validación dummy: reemplazar por validación real según necesites
    if ($email === "aaguiar@tequilavolcan.com.mx" && $password === "AguiarVeliz") {
        $_SESSION['user'] = ['email' => $email];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
    }
    exit;
} else {
    http_response_code(404);
    echo "404 Not Found";
}


