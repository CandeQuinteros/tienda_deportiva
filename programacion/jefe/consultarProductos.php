<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_deportiva";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(['message' => 'Conexión fallida: ' . $conn->connect_error]));
}

$sql = "SELECT codigo_producto, descripcion, precio FROM productos";
$result = $conn->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    $productos = ['message' => 'No se encontraron productos.'];
}

echo json_encode($productos);

$conn->close();
?>
