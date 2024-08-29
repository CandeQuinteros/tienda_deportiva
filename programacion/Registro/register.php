<?php
header('Content-Type: application/json');

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_deportiva";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => "Conexión fallida: " . $conn->connect_error]));
}

$nombre_usuario = $_POST['nombre_usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';
$superpoderes = isset($_POST['superpoderes']) ? 1 : 0;

// Verificar si el nombre de usuario ya existe
$sql_check = "SELECT id FROM usuarios WHERE nombre_usuario = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $nombre_usuario);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'El nombre de usuario ya está en uso. Por favor, elija otro nombre.']);
} else {
    // Encriptar la contraseña
    $contrasena_encriptada = password_hash($contrasena, PASSWORD_BCRYPT);

    // Insertar el nuevo usuario
    $sql_insert = "INSERT INTO usuarios (nombre_usuario, contrasena, poderes) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sss", $nombre_usuario, $contrasena_encriptada, $superpoderes);

    if ($stmt_insert->execute()) {
        $redirect_url = $superpoderes ? 'http://localhost/programacion/jefe/ventas.php' : 'http://localhost/programacion/index.php';
        echo json_encode(['success' => true, 'redirect' => $redirect_url]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en el registro. Intente nuevamente.']);
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
