<?php
session_start();

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$data = json_decode(file_get_contents('php://input'), true);
$carrito = $data['carrito'];

$conn = new mysqli("localhost", "root", "", "tienda_deportiva");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error en la conexión a la base de datos']);
    exit;
}

// Insertar el pedido
$stmt = $conn->prepare("INSERT INTO pedidos (id_usuario, estado, fecha, total) VALUES (?, 'pendiente', NOW(), ?)");
$total = array_reduce($carrito, function($sum, $item) { return $sum + $item['precio'] * $item['cantidad']; }, 0);
$stmt->bind_param("id", $cliente_id, $total);
$stmt->execute();
$pedido_id = $stmt->insert_id;

// Insertar detalles del pedido
$stmt = $conn->prepare("INSERT INTO detalles_pedido (id_pedido, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
foreach ($carrito as $item) {
    $stmt->bind_param("iiid", $pedido_id, $item['id'], $item['cantidad'], $item['precio']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'message' => 'Compra realizada con éxito']);
?>

