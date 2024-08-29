<?php
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$conn = new mysqli("localhost", "root", "", "tienda_deportiva");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['cantidad'])) {
        $pedido_id = null;

        // Crear nuevo pedido
        $sql = "INSERT INTO pedidos (cliente_id) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cliente_id);
        if ($stmt->execute()) {
            $pedido_id = $stmt->insert_id;
        }
        $stmt->close();

        if ($pedido_id) {
            foreach ($_POST['cantidad'] as $producto_id => $cantidad) {
                if ($cantidad > 0) {
                    $sql = "INSERT INTO pedidos_detalle (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iii", $pedido_id, $producto_id, $cantidad);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            echo "Compra registrada como pendiente. <a href='pedidos.php'>Ver pedidos</a>";
        } else {
            echo "Error al crear el pedido.";
        }
    }
}
$conn->close();
?>
