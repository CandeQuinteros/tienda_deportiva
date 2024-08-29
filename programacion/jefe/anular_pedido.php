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

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo_pedido']) && !empty($_POST['codigo_pedido'])) {
        // Obtener el ID del pedido del formulario y sanitizarlo
        $codigoPedido = intval($_POST['codigo_pedido']);

        // Preparar y ejecutar la consulta para eliminar los detalles del pedido
        $sqlEliminarDetalles = "DELETE FROM detalles_pedido WHERE id_pedido = ?";
        if ($stmtDetalles = $conn->prepare($sqlEliminarDetalles)) {
            $stmtDetalles->bind_param("i", $codigoPedido);
            $stmtDetalles->execute();
            
            // Verificar si se eliminaron detalles
            $detallesEliminados = $stmtDetalles->affected_rows;
            $stmtDetalles->close();
        } else {
            echo "Error en la preparación de la consulta para eliminar detalles: " . $conn->error . "<br>";
            exit;
        }

        // Ahora eliminar el pedido
        $sqlEliminarPedido = "DELETE FROM pedidos WHERE id = ?";
        if ($stmtPedido = $conn->prepare($sqlEliminarPedido)) {
            $stmtPedido->bind_param("i", $codigoPedido);
            $stmtPedido->execute();

            // Verificar si se eliminó el pedido
            $pedidoEliminado = $stmtPedido->affected_rows;
            $stmtPedido->close();
        } else {
            echo "Error en la preparación de la consulta para eliminar pedido: " . $conn->error . "<br>";
            exit;
        }

        // Mostrar mensaje basado en la eliminación del pedido
        if ($pedidoEliminado > 0) {
            echo "Pedido eliminado correctamente.";
        } else {
            echo "No se encontró el pedido o ya ha sido eliminado.";
        }
    } else {
        echo "Por favor, ingrese un código de pedido válido.";
    }
}

// Cerrar la conexión
$conn->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anular Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h2 {
            color: #007BFF;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    
    <h2>Anular Pedido</h2>
    <form method="POST" action="">
        <label for="codigo-pedido">Código del Pedido:</label>
        <input type="text" id="codigo-pedido" name="codigo_pedido" required>
        <button type="submit">Anular Pedido</button>
    </form>
    <a href="ventas.php">Volver a pagina principal</a>
</body>
</html>
