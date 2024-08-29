<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_deportiva";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos de la compra
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['carrito']) && isset($data['total'])) {
    $carrito = $data['carrito'];
    $total = $data['total'];

    foreach ($carrito as $item) {
        $descripcion = $item['descripcion'];
        $cantidad = $item['cantidad'];
        $precio = $item['precio'];

        $sql = "INSERT INTO pedidos (descripcion, cantidad, precio, estado) VALUES (?, ?, ?, 'pendiente')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sid", $descripcion, $cantidad, $precio);

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
            $stmt->close();
            $conn->close();
            exit;
        }

        $stmt->close();
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Datos de compra inválidos']);
}

$conn->close();
?>

