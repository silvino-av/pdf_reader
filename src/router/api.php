<?php

require_once __DIR__ . '/../helpers/db.php';
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';

if ($uri === '/api/login') {
    try {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['message' => 'Método no permitido']);
            exit;
        }
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $conn = getDBConnection();
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email= ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (hash('sha256', $password) === $row['password']) {
                $_SESSION['user'] = $row['name'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role'] = $row['role'] ?? 'user';
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciales inválidas']);
        }
        $stmt->close();
        $conn->close();
    } catch (\Throwable $th) {
        http_response_code(500);
        echo json_encode(['message' => 'Error interno del servidor']);
    } finally {
        exit;
    }
} else if ($uri === '/api/logout') {
    try {
        session_unset(); // Eliminar todas las variables de sesión
        session_destroy(); // Destruir la sesión
        // También puedes eliminar la cookie de sesión si es necesario
        setcookie(session_name(), '', time() - 3600, '/');
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Sesión cerrada correctamente']);
    } catch (\Throwable $th) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al cerrar la sesión']);
    } finally {
        exit;
    }
} else if ($uri === '/api/user') {
    try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? '';
            $password = $_POST['password'] ?? '';
            $password = hash('sha256', $password);

            // Validar los datos recibidos
            if (empty($name) || empty($email) || empty($role) || empty($password)) {
                http_response_code(400);
                echo json_encode(['message' => 'Todos los campos son obligatorios']);
                exit;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['message' => 'El correo electrónico no es válido']);
                exit;
            }
            if (!in_array($role, ['admin', 'user'])) {
                http_response_code(400);
                echo json_encode(['message' => 'El rol no es válido']);
                exit;
            }

            // Conectar a la base de datos
            $conn = getDBConnection();
            $id = $_POST['id'] ?? '';

            if (empty($id)) {
                $sql    = "INSERT INTO users (name, email, role, password) VALUES (?, ?, ?, ?)";
                $types  = "ssss";
                $params = [$name, $email, $role, $password];
            } else {
                $sql    = "UPDATE users SET name=?, email=?, role=?, password=? WHERE id=?";
                $types  = "ssssi";
                $params = [$name, $email, $role, $password, $id];
            }

            $stmt = $conn->prepare($sql);
            $stmt->bind_param($types, ...$params);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
            }
            $stmt->close();
            $conn->close();

        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $id = $_GET['id'] ?? '';
            if (empty($id)) {
                http_response_code(400);
                echo json_encode(['message' => 'ID de usuario no proporcionado']);
                exit;
            }
            $conn = getDBConnection();
            $stmt = $conn->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
            if (!$stmt) {
                http_response_code(500);
                echo json_encode(['message' => 'Error al preparar la consulta']);
                exit;
            }
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
            }
            $stmt->close();
            $conn->close();
        } else {
            http_response_code(405);
            echo json_encode(['message' => 'Método no permitido']);
            exit;
        }
    } catch (\Throwable $th) {
        http_response_code(500);
        echo json_encode(['message' => 'Error interno del servidor' . $th]);
    } finally {
        exit;
    }
} else {
    http_response_code(404);
    // echo "404 Not Found";
}
