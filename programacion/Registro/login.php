<?php
session_start();

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    $conn = new mysqli("localhost", "root", "", "tienda_deportiva");
    if ($conn->connect_error) {
        $response['success'] = false;
        $response['message'] = "Conexión fallida: " . $conn->connect_error;
        echo json_encode($response);
        exit;
    }

    // Consulta modificada para incluir `poderes`
    $sql = "SELECT id, contrasena, poderes FROM usuarios WHERE nombre_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre_usuario);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $poderes);

    if ($stmt->fetch() && password_verify($contrasena, $hashed_password)) {
        $_SESSION['cliente_id'] = $id;
        
        // Redirigir basado en el valor de `poderes`
        if ($poderes) {
            $response['redirect'] = 'http://localhost/programacion/jefe/ventas.php';
        } else {
            $response['redirect'] = 'http://localhost/programacion/index.php';
        }
        
        $response['success'] = true;
    } else {
        $response['success'] = false;
        $response['message'] = "Usuario o contraseña incorrectos.";
    }

    $stmt->close();
    $conn->close();
} else {
    $response['success'] = false;
    $response['message'] = "Método de solicitud no permitido.";
}

echo json_encode($response);
?>
